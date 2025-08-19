<?php

namespace App\Service;

use App\DTO\Product\ProductCreationDto;
use App\DTO\Product\ProductUpdateDto;
use App\DTO\Product\ProductUpdateImageDto;
use App\Entity\ProductCatalog;
use App\Entity\ProductCategory;
use App\Entity\ProductSupplier;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class ProductService
{
    public function __construct(
        private CategoryService $categoryService,
        private SupplierService $supplierService,
        private ProductRepository $productRepository,
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }

    public function getProductById(string $id): ?ProductCatalog
    {
        $product = $this->productRepository->find($id);
        if (!$product instanceof ProductCatalog) {
            return null;
        }

        return $product;
    }

    public function getList(): array
    {
        return $this->productRepository->findAll();
    }

    public function createProduct(ProductCreationDto $dto): ?ProductCatalog
    {
        $category = $this->categoryService->getCategoryById($dto->category_id);
        if (!$category instanceof ProductCategory) {
            return null;
        }

        $supplier = $this->supplierService->getSupplierById($dto->supplier_id);
        if (!$supplier instanceof ProductSupplier) {
            return null;
        }

        $user = $this->security->getUser();

        $product = new ProductCatalog(
            name: $dto->name,
            description: $dto->description,
            price: $dto->price,
            file_url: $dto->file_url ?? '',
            category: $category,
            supplier: $supplier,
            user: $user,
            created_at: new \DateTimeImmutable()
        );

        $this->entityManager->persist($product);

        $this->entityManager->flush();

        return $product;
    }

    public function updateProduct(ProductUpdateDto $dto): ?ProductCatalog
    {
        $product = $this->productRepository->find($dto->id);
        if (!$product) {
            return null;
        }

        $category = $this->categoryService->getCategoryById($dto->category_id);
        if (!$category instanceof ProductCategory) {
            return null;
        }

        $supplier = $this->supplierService->getSupplierById($dto->supplier_id);
        if (!$supplier instanceof ProductSupplier) {
            return null;
        }

        $user = $this->security->getUser();

        $product->setName($dto->name);
        $product->setDescription($dto->description);
        $product->setPrice($dto->price);
        $product->setFileUrl($dto->file_url);
        $product->setCategory($category);
        $product->setSupplier($supplier);
//        $product->setUpdatedAt(new \DateTimeImmutable());
        $product->setUpdatedBy($user);

        $this->entityManager->persist($product);

        $this->entityManager->flush();

        return $product;
    }

    public function updateProductImage(ProductUpdateImageDto $dto): ?ProductCatalog
    {
        $product = $this->productRepository->find($dto->id);
        if (!$product) {
            return null;
        }

        $user = $this->security->getUser();

        $product->setFileUrl($dto->file_url);
//        $product->setUpdatedAt(new \DateTimeImmutable());
        $product->setUpdatedBy($user);

        $this->entityManager->persist($product);

        $this->entityManager->flush();

        return $product;
    }

    public function deleteProductById(string $id): bool
    {
        $product = $this->productRepository->find($id);
        if (!$product instanceof ProductCatalog) {
            return false;
        }

        $this->entityManager->remove($product);

        $this->entityManager->flush();

        return true;
    }
}
