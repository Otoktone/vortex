<?php

namespace App\Controller\Front\User;

use App\Entity\Feed;
use App\Entity\Category;
use App\Entity\FeedArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserDashboardController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dashboard', name: 'dashboard')]
    public function index()
    {
        $feedRepository = $this->entityManager->getRepository(Feed::class);
        $feeds = $feedRepository->findAll();
        // $feedArticleRepository = $this->entityManager->getRepository(FeedArticle::class);
        // $feedArticles = $feedArticleRepository->findAll();

        // shuffle($feedArticles);

        return $this->render('front/user/dashboard.html.twig', [
            'feeds' => $feeds,
            // 'items' => $feedArticles,
        ]);
    }

    #[Route('/api/feed/articles', name: 'feed_article', methods: ['GET'])]
    public function getFeedArticles()
    {
        $feedArticleRepository = $this->entityManager->getRepository(FeedArticle::class);
        $feedArticles = $feedArticleRepository->findAll();
        shuffle($feedArticles);

        return $this->json($feedArticles);
    }

    #[Route('/api/category/list', name: 'category_list', methods: ['GET'])]
    public function getCategoryList(Security $security): JsonResponse
    {
        // get auth user
        $user = $security->getUser();

        $categoryRepository = $this->entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        return $this->json([
            'user' => $user->getId(),
            'categories' => $categories,
        ]);
    }
}
