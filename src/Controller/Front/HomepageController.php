<?php

namespace App\Controller\Front;

use App\Entity\FeedArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $frames = [
            [
                'id' => 1,
                'src' => '/build/images/frames/frame1.jpg',
                'class' => 'fa-brands fa-hotjar',
                'title' => 'Stay updated',
                'text' => 'Real-time Updates.',
                'description' => 'Stay informed with real-time updates as new articles and news stories are published. Our platform continuously monitors the feeds to deliver the latest information directly to you.'
            ],
            [
                'id' => 2,
                'src' => '/build/images/frames/frame2.jpg',
                'class' => 'fa-brands fa-hotjar',
                'title' => 'Bookmark articles',
                'text' => 'Bookmark and Save.',
                'description' => 'Found an interesting article? Save it for later! Our application enables you to bookmark articles, making it easy to revisit and read them at your convenience.'
            ],
            [
                'id' => 3,
                'src' => '/build/images/frames/frame3.jpg',
                'class' => 'fa-brands fa-hotjar',
                'title' => 'Customize feed',
                'text' => 'Personalized Experience.',
                'description' => 'Customize your news feed based on your interests and preferences. Our application allows you to choose specific categories or topics that you find most relevant, ensuring that you receive content tailored to your preferences.'
            ],
            [
                'id' => 4,
                'src' => 'build/images/frames/frame4.jpg',
                'class' => 'fa-brands fa-hotjar',
                'title' => 'Be up to date',
                'text' => 'Comprehensive Feed Collection.',
                'description' => 'Our application gathers feeds from multiple sources, including news websites, blogs, and online publications. We carefully curate these feeds to ensure a diverse and engaging selection of content.'
            ],
        ];

        $selectedPart = $frames[0] ?? null;

        $feedArticleRepository = $this->entityManager->getRepository(FeedArticle::class);
        $feedArticles = $feedArticleRepository->findAll();
        shuffle($feedArticles);

        return $this->render('front/homepage.html.twig', array(
            'frames' => $frames,
            'feedArticles' => $feedArticles,
            'selectedPart' => $selectedPart,
            'controller' => 'HomepageController'
        ));
    }

    #[Route('/policies', name: 'policies')]
    public function policies(): Response
    {
        return $this->render('front/policies.html.twig');
    }

    #[Route('/legal-notices', name: 'legal')]
    public function legal(): Response
    {
        return $this->render('front/legal.html.twig');
    }
}
