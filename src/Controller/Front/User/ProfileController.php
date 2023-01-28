<?php

namespace App\Controller\Front\User;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route("/profile", name: "profile")]
    public function index()
    {
        return $this->render('front/user/profile.html.twig');
    }
}
