<?php

namespace App\Controller\Front\User;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

class UserCategoryController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    #[Route('/api/user/category/{categories}/{user}', name: 'api_user_category', methods: ['GET'])]
    public function saveUserCategories(string $categories, string $user)
    {
        // fetch data send by form
        $categoryIds = array_filter(explode(',', $categories));
        if ($categoryIds === null) {
            throw new \InvalidArgumentException('Categories parameter is missing');
        }

        // get user data from db
        $user = $this->entityManager->getRepository(User::class)->find($user);

        // clear category list current user
        $user->getCategories()->clear();

        // update categories selected by current user
        foreach ($categoryIds as $categoryId) {
            $category = $this->entityManager->getRepository(Category::class)->find($categoryId);
            if ($category !== null) {
                $user->addCategory($category);
            } else {
                throw new \InvalidArgumentException(sprintf('Category with ID %d not found', $categoryId));
            }
        }
        $this->entityManager->flush();

        $categories = $user->getCategories()->map(function ($category) {
            return ['id' => $category->getId(), 'name' => $category->getName()];
        })->toArray();

        return new JsonResponse(['success' => true, 'user' => $user->getId(), 'categories' => $categories, 'message' => 'Categories updated successfully']);
    }

    #[Route('/api/user/categories', name: 'api_user_categories', methods: ['GET'])]
    public function getUserCategories()
    {
        $user = $this->getUser();

        $categories = $user->getCategories();

        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryIds[] = $category->getId();
        }

        return $this->json(['categories' => $categoryIds, 'user' => $user->getId()]);
    }
}
