<?php

namespace App\Controller\Back\Admin;

use App\Entity\Category;
use App\Entity\Feed;
use App\Entity\FeedArticle;
use App\Entity\User;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
    ) {
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        // // ...set chart data and options somehow

        // $chart->setData([
        //     'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        //     'datasets' => [
        //         [
        //             'label' => 'My First dataset',
        //             'backgroundColor' => 'rgb(255, 99, 132)',
        //             'borderColor' => 'rgb(255, 99, 132)',
        //             'data' => [0, 10, 5, 2, 20, 30, 45],
        //         ],
        //     ],
        // ]);

        // $chart->setOptions([
        //     'scales' => [
        //         'y' => [
        //             'suggestedMin' => 0,
        //             'suggestedMax' => 100,
        //         ],
        //     ],
        // ]);

        // return $this->render('back/admin/dashboard.html.twig', [
        //     'chart' => $chart,
        // ]);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('back/admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Vortex')
            ->setFaviconPath('build/images/icons/favicon_back.png');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::section('Menu'),
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Utilisateurs'),
            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),

            MenuItem::section('Flux'),
            MenuItem::linkToCrud('Flux RSS', 'fa fa-rss', Feed::class),
            MenuItem::linkToCrud('Articles', 'fa fa-file', FeedArticle::class),
            MenuItem::linkToCrud('Catégories', 'fa fa-list', Category::class),

            MenuItem::section('Back to Vortex'),
            MenuItem::linkToRoute('Home', 'fa fa-home', 'home'),
        ];
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $userAvatar = $user->getImageFile();

        // check if user got profile image
        // if ($userAvatar) {
        //     $imagePath = 'build/images/users/' . $userAvatar;
        // } else {
        //     // if not we define default image
        //     $imagePath = 'build/images/default-user-image.png';
        // }

        return parent::configureUserMenu($user)
        // ->setAvatarUrl($imagePath)
        ->setName($user->getUsername())
        // ->addMenuItems([
        //     MenuItem::linkToRoute('Mon Profil', 'fa fa-id-card', '...', ['...' => '...']),
        //     MenuItem::linkToRoute('Paramètres', 'fa fa-user-cog', '...', ['...' => '...']),
        // ])
        ;
    }
}
