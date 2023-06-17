<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route(path: '/error/404', name: 'error_404')]
    public function error404(): Response
    {
        return $this->render('front/security/404.html.twig');
    }
}
