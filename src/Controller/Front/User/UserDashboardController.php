<?php

namespace App\Controller\Front\User;

use App\Entity\User;
use App\Entity\Feed;
use App\Entity\Category;
use App\Entity\FeedArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
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
        $user = $this->getUser();
        $userId = $user->getId();

        $feedRepository = $this->entityManager->getRepository(Feed::class);
        $feeds = $feedRepository->findAll();

        $feedArticleRepository = $this->entityManager->getRepository(FeedArticle::class);
        $feedArticles = $feedArticleRepository->findAll();

        $categoryRepository = $this->entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        shuffle($feedArticles);

        return $this->render('front/user/dashboard.html.twig', [
            'feeds' => $feeds,
            'userId' => $userId,
            'items' => $feedArticles,
            'categories' => $categories,
        ]);
    }

    #[Route('/api/feed/articles', name: 'feed_article', methods: ['GET'])]
    public function getFeedArticles()
    {
        $feedArticleRepository = $this->entityManager->getRepository(FeedArticle::class);
        $feedArticles = $feedArticleRepository->findAll();
        shuffle($feedArticles);

        // remove users from serialization (avoid cycling error)
        foreach ($feedArticles as $feedArticle) {
            $feedArticle->getUsers()->clear();
        }

        return $this->json($feedArticles);
    }

    #[Route('/api/feed/articles', name: 'feed_bookmark', methods: ['POST'])]
    public function addBookmark(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);
        $userId = $data['userId'];
        $articleId = $data['articleId'];

        $user = $entityManager->getRepository(User::class)->find($userId);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $article = $entityManager->getRepository(FeedArticle::class)->find($articleId);

        if (!$article) {
            return new JsonResponse(['message' => 'Article not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $user->addFavoriteArticle($article);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Article added to bookmarks']);
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
