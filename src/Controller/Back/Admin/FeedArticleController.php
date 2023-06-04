<?php

namespace App\Controller\Back\Admin;


use App\Entity\FeedArticle;
use App\Repository\FeedArticleRepository;
use App\Service\ArticleGenerator;
use FeedIo\FeedIo;
use FeedIo\Adapter\Http\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttplugClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\{Action, Actions, Crud};
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField, TextareaField, TextField};

#[Route('/feed/article')]
class FeedArticleController extends AbstractCrudController
{
    private ArticleGenerator $articleGenerator;

    public function __construct(ArticleGenerator $articleGenerator)
    {
        $this->articleGenerator = $articleGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return FeedArticle::class;
    }

    public function generateArticleFromRss()
    {
        $this->articleGenerator->generateArticleFromRss();

        return new JsonResponse(['message' => 'Articles generated']);
    }

    #[Route('/generate-article/{id}', name: 'generate_article_route', requirements: ['id' => '\d+'], defaults: ['id' => null])]
    public function generateArticleAction(?int $id = null, ArticleGenerator $articleGenerator)
    {

        if ($id !== null) {
            // calling ArticleGenerator service with id param
            $articleGenerator->generateArticleFromRss($id);
            $message = 'Articles generated for flux with id : ' . $id;
        } else {
            // calling ArticleGenerator service with all flux
            $articleGenerator->generateArticleFromRss();
            $message = 'Articles generated for all flux';
        }

        return new JsonResponse(['message' => $message]);
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('title')->setLabel('Title'),
            TextField::new('link')->setLabel('Link'),
            TextareaField::new('content')->setLabel('Content'),
            TextField::new('date')->setLabel('Date'),
            TextField::new('category')->setLabel('Category'),
            // TextField::new('media')->setLabel('Media'),
        ];

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('')
            ->setEntityLabelInPlural('Articles');
    }

    // public function configureFilters(Filters $filters): Filters
    // {
    //     return $filters
    //         ->add(EntityFilter::new('FeedArticle'));
    // }
}
