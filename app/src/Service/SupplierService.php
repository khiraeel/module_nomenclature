<?php

namespace App\Service;

use App\DTO\Supplier\SupplierCreationDto;
use App\DTO\Supplier\SupplierUpdateDto;
use App\Entity\ProductSupplier;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class SupplierService
{
    public function __construct(
        private SupplierRepository $supplierRepository,
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }

    public function getById(string $id): ?ProductSupplier
    {
        $supplier = $this->supplierRepository->find($id);
        if (!$supplier instanceof ProductSupplier) {
            return null;
        }

        return $supplier;
    }

    public function getSupplierById(string $id): ?ProductSupplier
    {
        return $this->supplierRepository->find($id);
    }

    public function getList(): array
    {
        return $this->supplierRepository->findAll();
    }

    public function createSupplier(SupplierCreationDto $dto): ?ProductSupplier
    {
        $getSupplierByName = $this->supplierRepository->findOneBy(['name' => $dto->name]);
        if ($getSupplierByName instanceof ProductSupplier) {
            return null;
        }

        $user = $this->security->getUser();

        $supplier = new ProductSupplier(
            $dto->name,
            $dto->description,
            $dto->phone,
            $dto->contactName,
            $dto->website,
            $user,
            new \DateTimeImmutable()
        );

        $this->entityManager->persist($supplier);

        $this->entityManager->flush();

        return $supplier;
    }

    public function updateSupplier(SupplierUpdateDto $dto): ?ProductSupplier
    {
        $supplier = $this->supplierRepository->find($dto->id);
        if (!$supplier instanceof ProductSupplier) {
            return null;
        }

        $supplierByName = $this->supplierRepository->findOneBy(['name' => $dto->name]);
        if ($supplierByName instanceof ProductSupplier && $supplierByName->getId() !== $dto->id) {
            return null;
        }
        $user = $this->security->getUser();

        $supplier->setName($dto->name);
        $supplier->setDescription($dto->description);
        $supplier->setPhone($dto->phone);
        $supplier->setContactName($dto->contactName);
        $supplier->setWebsite($dto->website);
        $supplier->setUpdatedBy($user);
        $supplier->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $supplier;
    }

    public function deleteById(string $id): bool
    {
        $supplier = $this->supplierRepository->find($id);
        if (!$supplier instanceof ProductSupplier) {
            return false;
        }

        $this->entityManager->remove($supplier);

        $this->entityManager->flush();

        return true;
    }
}
