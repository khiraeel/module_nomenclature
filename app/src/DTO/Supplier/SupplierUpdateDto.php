<?php

namespace App\DTO\Supplier;

use App\Interface\JsonBodyDtoRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class SupplierUpdateDto implements JsonBodyDtoRequestInterface
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $id,
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $description,
        #[Assert\NotBlank]
        public string $phone, // нужен кастомный констрейнт
        #[Assert\NotBlank]
        public string $contactName,
        #[Assert\NotBlank]
        public string $website,
    ) {
    }
}
