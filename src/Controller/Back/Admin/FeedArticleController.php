<?php

namespace App\Controller\Back\Admin;

use App\Entity\Category;
use App\Entity\Feed;
use App\Entity\FeedArticle;
use App\Repository\FeedArticleRepository;
use FeedIo\FeedIo;
use FeedIo\Adapter\Http\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttplugClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Action, Actions, Crud, Filters};
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField, TextareaField, TextField};

#[Route('/feed/article')]
class FeedArticleController extends AbstractCrudController
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

    public static function getEntityFqcn(): string
    {
        return FeedArticle::class;
    }

    private function isValidFeedUrl(string $url): bool
    {
        try {
            $this->feedIo->read($url);
        } catch (\Exception $e) {
            echo 'Caught exception : ',  $e->getMessage(), "\n";
            return false;
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
                $newFilteredItem->setMedia($filteredItem['media']['imageUrl']);
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

    #[Route('/generate-article', name: 'generate_article_route')]
    public function generateArticleAction()
    {
        $this->generateArticle();

        return new JsonResponse(['message' => 'Articles generated']);
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('title')->setLabel('Title'),
            TextField::new('link')->setLabel('Link'),
            TextareaField::new('content')->setLabel('Content'),
            TextField::new('date')->setLabel('Date'),
            TextField::new('category')->setLabel('Category'),
            // TextField::new('media')->setLabel('Media'),
        ];

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('FeedArticle')); // TODO
    }
}
