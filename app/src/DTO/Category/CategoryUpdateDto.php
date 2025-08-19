<?php

namespace App\DTO\Category;

use App\Interface\JsonBodyDtoRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CategoryUpdateDto implements JsonBodyDtoRequestInterface
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $id,
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank(allowNull: true)]
        #[Assert\Uuid]
        public ?string $parentCategoryId,
    ) {
    }
}
