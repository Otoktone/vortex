<?php

namespace App\Controller\Front\User;

use App\Entity\Feed;
use App\Entity\FeedArticle;
use Doctrine\ORM\EntityManagerInterface;
use PDO;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserDashboardController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/dashboard", name: "dashboard")]
    public function index()
    {
        $feedRepository = $this->entityManager->getRepository(Feed::class);
        $feeds = $feedRepository->findAll();
        $feedArticleRepository = $this->entityManager->getRepository(FeedArticle::class);
        $feedArticles = $feedArticleRepository->findAll();

        shuffle($feedArticles);

        return $this->render('front/user/dashboard.html.twig', [
            'feeds' => $feeds,
            'items' => $feedArticles,
        ]);
    }
}
