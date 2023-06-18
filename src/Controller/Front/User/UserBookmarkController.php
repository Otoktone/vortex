<?php

namespace App\Controller\Front\User;

use App\Entity\FeedArticle;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserBookmarkController extends AbstractController
{

    #[Route('/bookmarks', name: 'bookmarks')]
    public function index()
    {
        $user = $this->getUser();
        $favoriteArticles = $user->getFavoriteArticles();

        return $this->render('front/user/bookmarks.html.twig', [
            'favoriteArticles' => $favoriteArticles,
            'userId' => $user,
        ]);
    }

    #[Route('/api/feed/articles/remove', name: 'feed_remove_bookmark', methods: ['POST'])]
    public function removeFavoriteArticle(Request $request): JsonResponse
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

        $user->removeFavoriteArticle($article);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Article removed from bookmarks']);
    }
}
