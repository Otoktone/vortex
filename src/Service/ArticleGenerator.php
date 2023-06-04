<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Feed;
use App\Entity\FeedArticle;
use App\Repository\FeedArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FeedIo\FeedIo;
use FeedIo\Adapter\Http\Client;
use Symfony\Component\HttpClient\HttplugClient;

class ArticleGenerator
{
    private EntityManagerInterface $entityManager;
    private Client $client;
    private FeedIo $feedIo;
    private FeedArticleRepository $feedArticleRepository;
    private array $validFeeds = [];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->client = new Client(new HttplugClient());
        $this->feedIo = new FeedIo($this->client);
        $this->feedArticleRepository = $entityManager->getRepository(FeedArticle::class);
    }

    private function isValidFeedUrl(string $url): bool
    {
        try {
            $this->feedIo->read($url);
        } catch (\Exception $e) {
            // echo 'Caught exception : ',  $e->getMessage(), "\n";
            // return false;
            throw new \Exception('Caught exception: ' . $e->getMessage());
        }
        return true;
    }

    public function generateArticleFromRss()
    {
        $feeds = $this->entityManager->getRepository(Feed::class)->findAll();


        // check url validity before generating articles
        foreach ($feeds as $feed) {
            if ($this->isValidFeedUrl($feed->getUrl())) {
                $this->validFeeds[] = $feed;
            }
        }

        // get current year in order to filter articles
        $currentYear = (int) (new \DateTime())->format('Y');

        $items = [];
        $filteredItems = [];
        foreach ($this->validFeeds as $feed) {
            if ($this->isValidFeedUrl($feed->getUrl())) {
                // if url is valid then read the feed
                $result = $this->feedIo->read($feed->getUrl());
                $currentFeed = $result->getFeed();
                foreach ($currentFeed as $item) {
                    $categories = $item->getCategories();
                    foreach ($categories as $category) {
                        $categoryTerm = $category->getTerm();

                        $existingCategory = $this->entityManager->getRepository(Category::class)->findOneBy(['name' => $categoryTerm]);

                        // create categories if it doesnt exit yet
                        if (!$existingCategory) {
                            $newCategory = new Category();
                            $newCategory->setName($categoryTerm);
                            $this->entityManager->persist($newCategory);
                            $this->entityManager->flush();
                        }
                    }
                    $mediaImage = null;
                    $content = $item->getContent();
                    // check if there is media balise, otherwise look for img balise inside content
                    preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $image);
                    if (isset($image['src'])) {
                        $mediaImage = ['imageUrl' => $image['src']];
                    } else {
                        foreach ($item->getMedias() as $media) {
                            $imageUrl = $media->getUrl();
                            if (!empty($imageUrl)) {
                                $mediaImage = ['imageUrl' => $imageUrl];
                            }
                        }
                    }
                    // remove html balises and manage special characters
                    $content = html_entity_decode(strip_tags($item->getContent()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $date = $item->getLastModified();
                    $itemYear = (int) $date->format('Y');
                    if ($itemYear === $currentYear) {
                        $items[] = [
                            'title' => $item->getTitle(),
                            'content' => $content,
                            'link' => $item->getLink(),
                            'date' => $date,
                            'media' => $mediaImage,
                            'category' => $categoryTerm
                        ];
                    }
                    $currentDate = new \DateTime();
                    $lastMonth = $currentDate->modify('-1 month');

                    $filteredItems = array_filter($items, function ($item) use ($lastMonth) {
                        return $item['date'] >= $lastMonth;
                    });
                }
            }
        }
        foreach ($filteredItems as $filteredItem) {
            // check if article is already registered into db
            $existingArticle = $this->feedArticleRepository->findOneBy(['link' => $filteredItem['link']]);
            if (!$existingArticle) {
                $newFilteredItem = new FeedArticle();
                $newFilteredItem->setTitle($filteredItem['title']);
                $newFilteredItem->setContent($filteredItem['content']);
                $newFilteredItem->setLink($filteredItem['link']);
                $newFilteredItem->setDate($filteredItem['date']->format('Y-m-d H:i:s'));
                if (isset($filteredItem['media']['imageUrl'])) {
                    $newFilteredItem->setMedia($filteredItem['media']['imageUrl']);
                } else {
                    $newFilteredItem->setMedia(null);
                }
                $newFilteredItem->setCategory($filteredItem['category']);
                $this->entityManager->persist($newFilteredItem);
            }
        }
        $this->entityManager->flush();
    }

    public function generateArticle()
    {
        $this->generateArticleFromRss();
    }
}
