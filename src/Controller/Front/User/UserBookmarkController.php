<?php

namespace App\Controller\Front\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserBookmarkController extends AbstractController {

    #[Route('/bookmarks', name: 'bookmarks')]
    public function index() {
        $user = $this->getUser();
        $favoriteArticles = $user->getFavoriteArticles();

        return $this->render('front/user/bookmarks.html.twig', [
            'favoriteArticles' => $favoriteArticles,
        ]);
    }
}