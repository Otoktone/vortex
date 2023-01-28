<?php

namespace App\Controller\Front\User;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserDashboardController extends AbstractController
{
    #[Route("/dashboard", name: "dashboard")]
    public function index()
    {
        return $this->render('front/user/dashboard.html.twig');
    }
}
