<?php

namespace App\Controller\Back\User;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfileController extends AbstractController
{
    #[Route("/profile", name: "profile")]
    public function index()
    {
        return $this->render('back/user/profile.html.twig');
    }
}
