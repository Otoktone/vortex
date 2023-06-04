<?php

namespace App\Controller\Back\Admin;


use App\Entity\Feed;
use App\Entity\FeedArticle;
use Symfony\Component\Validator\Constraints\Url;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use Symfony\Component\Form\{FormBuilderInterface, FormEvents};
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Form\Extension\Core\Type\{PasswordType, RepeatedType};
use EasyCorp\Bundle\EasyAdminBundle\Config\{Crud, KeyValueStore, Action, Actions};
use EasyCorp\Bundle\EasyAdminBundle\Field\{ChoiceField, IdField, EmailField, ImageField, TextField, UrlField};

class FeedCrudController extends AbstractCrudController
{

    // public const ACTION_GENERATE = "generate";

    public function __construct()
    {
    }

    public static function getEntityFqcn(): string
    {
        return Feed::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm(),
            TextField::new('name')->setLabel('Flux'),

            // Check url validity
            TextField::new('url')
                ->setLabel('Url')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Url(),
                    ],
                ]),

            // ImageField::new('imageFile')->setLabel('Image')->setBasePath('build/images/users/')->setUploadDir('assets/images/users/')->setFormType(FileUploadType::class)->setUploadedFileNamePattern('[randomhash].[extension]'),
            // ChoiceField::new('roles')->allowMultipleChoices(true)->setChoices([
            //     'Utilisateur' => 'ROLE_USER',
            //     'Admin' => 'ROLE_ADMIN',
            // ]),
        ];

        // $password = TextField::new('password')
        //     ->setLabel('Mot de passe')
        //     ->setFormType(RepeatedType::class)
        //     ->setFormTypeOptions([
        //         'type' => PasswordType::class,
        //         'first_options' => ['label' => 'Password'],
        //         'second_options' => ['label' => '(Repeat)'],
        //         'mapped' => false,
        //     ])
        //     ->setRequired($pageName === Crud::PAGE_NEW)
        //     ->onlyOnForms();
        // $fields[] = $password;

        return $fields;
    }

    // public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    // {
    //     $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);
    //     return $this->$formBuilder;
    // }

    // public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    // {
    //     $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);
    //     return $this->$formBuilder;
    // }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('')
            ->setEntityLabelInPlural('Flux RSS');
    }

    // public function configureActions(Actions $actions): Actions
    // {
    //     $generate = Action::new(self::ACTION_GENERATE)
    //         ->displayAsLink('generate_article_route')
    //         ->linkToRoute('generate_article_route')
    //         ->setCssClass('btn btn-danger');

    //     return $actions
    //         ->add(Crud::PAGE_INDEX, $generate);
    // }
}
