<?php

namespace App\Controller;

use App\DTO\Product\ProductCreationDto;
use App\DTO\Product\ProductUpdateDto;
use App\DTO\Product\ProductUpdateImageDto;
use App\Entity\ProductCatalog;
use App\Service\ProductService;
use App\View\Products\ProductsView;
use App\View\Products\ProductsViewList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
final class ProductController extends BaseController
{
    public function __construct(
        private ProductService $productService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/products', name: 'products_list', methods: ['GET'])]
    public function productsList(Request $request): Response
    {
        $productsList = $this->productService->getList();
        $view = new ProductsViewList($productsList);

        return $this->createResponseSuccess($view->getData());
    }

    #[Route('/products/{id}', name: 'product_get', methods: ['GET'])]
    public function product(string $id): Response
    {
        $product = $this->productService->getProductById($id);
        $view = new ProductsView($product);

        return $this->createResponseSuccess($view->getData());
    }

    #[Route('/products', name: 'products_add', methods: ['POST'])]
    public function productCreate(ProductCreationDto $dto): Response
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }

        $product = $this->productService->createProduct($dto);
        if (!$product instanceof ProductCatalog) {
            return $this->createResponseBadRequest(['Bad request']);
        }

        $createdByUser = $product->getCreatedBy();
        $createdBy = [
            'user_id' => $createdByUser->getId(),
            'email' => $createdByUser->getEmail(),
            'login' => $createdByUser->getLogin(),
            'first_name' => $createdByUser->getFirstName(),
            'last_name' => $createdByUser->getLastName(),
        ];

        return $this->createResponseSuccess([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'image' => $product->getFileUrl(),
            'category_id' => $product->getCategory()->getId(),
            'supplier_id' => $product->getSupplier()->getId(),
            'createdBy' => $createdBy,
            'update_by' => $createdBy,
            'created_at' => $product->getCreatedAt(),
            'updated_at' => $product->getUpdatedAt(),
        ]);
    }

    #[Route('/products/{id}', name: 'product_update', methods: ['PUT'])]
    public function productUpdate(ProductUpdateDto $dto): Response
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }
        $product = $this->productService->updateProduct($dto);
        if (!$product instanceof ProductCatalog) {
            return $this->createResponseBadRequest(['Bad request']);
        }
        $view = new ProductsView($product);

        return $this->createResponseSuccess($view->getData());
    }

    #[Route('/products/{id}', name: 'product_delete', methods: ['DELETE'])] // soft delete
    public function productDelete(string $id): Response
    {
        $product = $this->productService->deleteProductById($id);

        return $this->createResponseSuccess($product);
    }

    #[Route('/products/upload/{id}', name: 'product_upload', methods: ['POST'])] // загрузка изображения (jpg, jpeg, png)
    public function productsUpload(ProductUpdateImageDto $dto): Response
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }

        $product = $this->productService->updateProductImage($dto);

        return $this->createResponseSuccess($product);
    }

    #[Route('/products/import', name: 'product_import', methods: ['POST'])] // импорт товаров из CSV через очередь
    public function productsImport(Request $request): Response
    {
        return $this->createResponseSuccess(['Hello']);
    }
}
