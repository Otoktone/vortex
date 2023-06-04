<?php

namespace App\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $frames = [
            [
                'id' => 1,
                'src' => '/build/images/frames/frame1.jpg',
                'class' => 'fa-brands fa-hotjar',
                'title' => 'Stay updated',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
            ],
            [
                'id' => 2,
                'src' => '/build/images/frames/frame2.jpg',
                'class' => 'fa-brands fa-hotjar',
                'title' => 'Bookmark articles',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
            ],
            [
                'id' => 3,
                'src' => '/build/images/frames/frame3.jpg',
                'class' => 'fa-brands fa-hotjar',
                'title' => 'Customize feed',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
            ],
            [
                'id' => 4,
                'src' => 'build/images/frames/frame4.jpg',
                'class' => 'fa-brands fa-hotjar',
                'title' => 'Follow news',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.'
            ],
        ];

        $selectedPart = $frames[0] ?? null;

        return $this->render('front/homepage.html.twig', array(
            'frames' => $frames,
            'selectedPart' => $selectedPart,
            'controller' => 'HomepageController'
        ));
    }
}
