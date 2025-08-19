<?php

namespace App\DTO\Product;

use App\Interface\JsonBodyDtoRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ProductCreationDto implements JsonBodyDtoRequestInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        public string $description,
        #[Assert\NotBlank]
        public string $price,
        #[Assert\NotBlank(allowNull: true)]
        public string $file_url,
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $category_id,
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $supplier_id,
    ) {
    }
}
