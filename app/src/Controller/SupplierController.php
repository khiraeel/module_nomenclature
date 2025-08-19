<?php

namespace App\Controller;

use App\DTO\Supplier\SupplierCreationDto;
use App\DTO\Supplier\SupplierUpdateDto;
use App\Entity\ProductSupplier;
use App\Service\SupplierService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api', name: 'api_')]
class SupplierController extends BaseController
{
    public function __construct(
        private SupplierService $supplierService,
        private ValidatorInterface $validator,
    ) {
    }

    #[Route('/suppliers', name: 'suppliers_list', methods: ['GET'])]
    public function suppliersList(Request $request): Response
    {
        $suppliersList = $this->supplierService->getList();

        return $this->createResponseSuccess($suppliersList);
    }

    #[Route('/suppliers/{id}', name: 'supplier_get', methods: ['GET'])]
    public function supplierGet(string $id): Response
    {
        $supplier = $this->supplierService->getById($id);

        return $this->createResponseSuccess($supplier);
    }

    #[Route('/suppliers', name: 'supplier_create', methods: ['POST'])]
    public function supplierCreate(SupplierCreationDto $dto): Response
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }

        $supplier = $this->supplierService->createSupplier($dto);
        if (!$supplier instanceof ProductSupplier) {
            return $this->createResponseBadRequest(['Bad request']);
        }

        $createdByUser = $supplier->getCreatedBy();
        $createdBy = [
            'user_id' => $createdByUser->getId(),
            'email' => $createdByUser->getEmail(),
            'login' => $createdByUser->getLogin(),
            'first_name' => $createdByUser->getFirstName(),
            'last_name' => $createdByUser->getLastName(),
        ];

        return $this->createResponseSuccess([
            'id' => $supplier->getId(),
            'name' => $supplier->getName(),
            'description' => $supplier->getDescription(),
            'phone' => $supplier->getPhone(),
            'contact_name' => $supplier->getContactName(),
            'website' => $supplier->getWebsite(),
            'createdBy' => $createdBy,
            'update_by' => $createdBy,
            'created_at' => $supplier->getCreatedAt(),
            'updated_at' => $supplier->getUpdatedAt(),
        ]);
    }

    #[Route('/suppliers/{id}', name: 'supplier_update', methods: ['PUT'])]
    public function supplierUpdate(SupplierUpdateDto $dto): Response
    {
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return $this->createResponseBadRequest($errors);
        }

        $supplier = $this->supplierService->updateSupplier($dto);
        if (!$supplier instanceof ProductSupplier) {
            return $this->createResponseBadRequest(['Bad request']);
        }

        $createdByUser = $supplier->getCreatedBy();
        $updatedByUser = $supplier->getUpdatedBy();

        $createdBy = [
            'user_id' => $createdByUser->getId(),
            'email' => $createdByUser->getEmail(),
            'login' => $createdByUser->getLogin(),
            'first_name' => $createdByUser->getFirstName(),
            'last_name' => $createdByUser->getLastName(),
        ];

        $updatedBy = [
            'user_id' => $updatedByUser->getId(),
            'email' => $updatedByUser->getEmail(),
            'login' => $updatedByUser->getLogin(),
            'first_name' => $updatedByUser->getFirstName(),
            'last_name' => $updatedByUser->getLastName(),
        ];

        return $this->createResponseSuccess([
            'id' => $supplier->getId(),
            'name' => $supplier->getName(),
            'description' => $supplier->getDescription(),
            'phone' => $supplier->getPhone(),
            'contact_name' => $supplier->getContactName(),
            'website' => $supplier->getWebsite(),
            'createdBy' => $createdBy,
            'update_by' => $updatedBy,
            'created_at' => $supplier->getCreatedAt(),
            'updated_at' => $supplier->getUpdatedAt(),
        ]);
    }

    #[Route('/suppliers/{id}', name: 'supplier_delete', methods: ['DELETE'])]
    public function supplierDelete(string $id): Response
    {
        $isDeleted = $this->supplierService->deleteById($id);
        if (!$isDeleted) {
            return $this->createResponseBadRequest(['Bad request']);
        }

        return $this->createResponseSuccess(['deleted' => $isDeleted]);
    }
}
