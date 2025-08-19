<?php

namespace App\Service;

use App\DTO\Category\CategoryCreationDto;
use App\DTO\Category\CategoryUpdateDto;
use App\Entity\ProductCategory;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CategoryService
{
    public function __construct(
        private CategoryRepository $productCategoryRepository,
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }

    public function getList(): array
    {
        return $this->productCategoryRepository->findAll();
    }

    public function getCategoryById(string $id): ?ProductCategory
    {
        $category = $this->productCategoryRepository->find($id);
        if (!$category instanceof ProductCategory) {
            return null;
        }

        return $category;
    }

    public function createCategory(CategoryCreationDto $dto): ?ProductCategory
    {
        $getCategoryByName = $this->productCategoryRepository->findOneBy(['name' => $dto->name]);
        if ($getCategoryByName instanceof ProductCategory) {
            return null;
        }

        $parentCategory = null;
        if (isset($dto->parentCategoryId)) {
            $parentCategory = $this->productCategoryRepository->find($dto->parentCategoryId);
            if (!$parentCategory) {
                return null;
            }
        }

        $user = $this->security->getUser();

        $category = new ProductCategory(
            $dto->name,
            $parentCategory,
            $user,
            new \DateTimeImmutable()
        );

        $this->entityManager->persist($category);

        $this->entityManager->flush();

        return $category;
    }

    public function updateCategory(CategoryUpdateDto $dto): ?ProductCategory
    {
        $category = $this->productCategoryRepository->find($dto->id);
        if (!$category instanceof ProductCategory) {
            return null;
        }

        $getCategory = $this->productCategoryRepository->createQueryBuilder('c')
            ->where('c.id != :id')
            ->andWhere('c.name = :name')
            ->setParameter('id', $dto->id)
            ->setParameter('name', $dto->name)
            ->getQuery()
            ->getResult();

        // $getCategory = $this->productCategoryRepository->findBy(['!id' => $dto->id,'name' => $dto->name]);
        if ($getCategory instanceof ProductCategory) {
            return null;
        }

        if (
            isset($dto->parentCategoryId)
        ) {
            $parentCategory = $this->productCategoryRepository->find($dto->parentCategoryId);
            if (!$parentCategory instanceof ProductCategory || $dto->parentCategoryId === $dto->id) {
                return null;
            }
        }

        $user = $this->security->getUser();

        $category->setName($dto->name);
        $category->setParent($parentCategory);
        $category->setUpdatedAt(new \DateTimeImmutable());
        $category->setUpdatedBy($user);

        $this->entityManager->flush();

        return $category;
    }

    public function deleteCategoryById(string $id): bool
    {
        $category = $this->productCategoryRepository->find($id);
        if (!$category instanceof ProductCategory) {
            return false;
        }

        $this->entityManager->remove($category);

        $this->entityManager->flush();

        return true;
    }
}
