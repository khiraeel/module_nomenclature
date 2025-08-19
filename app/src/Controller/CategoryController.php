<?php

namespace App\Controller;

use App\DTO\Category\CategoryCreationDto;
use App\DTO\Category\CategoryUpdateDto;
use App\Entity\ProductCategory;
use App\Service\CategoryService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
final class CategoryController extends BaseController
{
    public function __construct(
        private CategoryService $categoryService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/categories', name: 'categories_list', methods: ['GET'])]
    public function categoriesList(Request $request): Response
    {
        $categoriesList = $this->categoryService->getList();

        return $this->createResponseSuccess($categoriesList);
    }

    #[Route('/categories/{id}', name: 'category_get', methods: ['GET'])]
    public function product(string $id): Response
    {
        $category = $this->categoryService->getCategoryById($id);

        $createdByUser = $category->getCreatedBy();
        $updatedByUser = $category->getUpdatedBy();

        return $this->createResponseSuccess([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'parent_id' => $category->getParent()?->getId(),
            'createdBy' => [
                'user_id' => $createdByUser->getId(),
                'email' => $createdByUser->getEmail(),
                'login' => $createdByUser->getLogin(),
                'first_name' => $createdByUser->getFirstName(),
                'last_name' => $createdByUser->getLastName(),
            ],
            'update_by' => [
                'user_id' => $updatedByUser->getId(),
                'email' => $updatedByUser->getEmail(),
                'login' => $updatedByUser->getLogin(),
                'first_name' => $updatedByUser->getFirstName(),
                'last_name' => $updatedByUser->getLastName(),
            ],
            'created_at' => $category->getCreatedAt(),
            'updated_at' => $category->getUpdatedAt(),
        ]);
    }

    #[Route('/categories', name: 'categories_add', methods: ['POST'])]
    public function categoryCreate(CategoryCreationDto $dto): Response
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }

        $category = $this->categoryService->createCategory($dto);
        if (!$category instanceof ProductCategory) {
            return $this->createResponseBadRequest(['Bad request']);
        }

        $createdByUser = $category->getUpdatedBy();
        $createdBy = [
            'user_id' => $createdByUser->getId(),
            'email' => $createdByUser->getEmail(),
            'login' => $createdByUser->getLogin(),
            'first_name' => $createdByUser->getFirstName(),
            'last_name' => $createdByUser->getLastName(),
        ];

        return $this->createResponseSuccess([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'parent_id' => $category->getParent()?->getId(),
            'createdBy' => $createdBy,
            'update_by' => $createdBy,
            'created_at' => $category->getCreatedAt(),
            'updated_at' => $category->getUpdatedAt(),
        ]);
    }

    #[Route('/categories/{id}', name: 'category_update', methods: ['PUT'])]
    public function categoryUpdate(CategoryUpdateDto $dto): Response
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }

        $categories = $this->categoryService->updateCategory($dto);

        return $this->createResponseSuccess($categories);
    }

    #[Route('/categories/{id}', name: 'category_delete', methods: ['DELETE'])]
    public function categoryDelete(string $id): Response
    {
        $product = $this->categoryService->deleteCategoryById($id);

        return $this->createResponseSuccess($product);
    }
}
