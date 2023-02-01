<?php

namespace App\Controller\Front\User;

use FeedIo\FeedIo;
use App\Entity\Feed;
use FeedIo\Adapter\Http\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttplugClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserDashboardController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Client $client;
    private FeedIo $feedIo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->client = new Client(new HttplugClient());
        $this->feedIo = new FeedIo($this->client);
    }

    private function isValidFeedUrl(string $url): bool
    {
        try {
            $this->feedIo->read($url);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    #[Route("/dashboard", name: "dashboard")]
    public function index()
    {
        $feedRepository = $this->entityManager->getRepository(Feed::class);
        $feeds = $feedRepository->findAll();

        $validFeeds = array_filter($feeds, function ($feed) {
            return $this->isValidFeedUrl($feed->getUrl());
        });

        $currentYear = (int) (new \DateTime())->format('Y');

        $items = [];
        foreach ($validFeeds as $feed) {
            if ($this->isValidFeedUrl($feed->getUrl())) {
                $result = $this->feedIo->read($feed->getUrl());
                $currentFeed = $result->getFeed();
                foreach ($currentFeed as $item) {
                    $mediaImage = null;
                    $content = $item->getContent();
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
                    $content = html_entity_decode(strip_tags($item->getContent()), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    $pubDate = $item->getLastModified();
                    $itemYear = (int) $pubDate->format('Y');
                    if ($itemYear === $currentYear) {
                        $items[] = [
                            'title' => $item->getTitle(),
                            'content' => $content,
                            'link' => $item->getLink(),
                            'pubDate' => $pubDate,
                            'media' => $mediaImage,
                        ];
                    }
                    $currentDate = new \DateTime();
                    $lastMonth = $currentDate->modify('-1 month');

                    $filteredItems = array_filter($items, function ($item) use ($lastMonth) {
                        return $item['pubDate'] >= $lastMonth;
                    });
                }
            }
        }
        shuffle($filteredItems);

        return $this->render('front/user/dashboard.html.twig', [
            'feeds' => $feeds,
            'items' => $filteredItems,
        ]);
    }
}
