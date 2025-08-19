<?php

namespace App\DTO\Category;

use App\Interface\JsonBodyDtoRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CategoryCreationDto implements JsonBodyDtoRequestInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank(allowNull: true)]
        #[Assert\Uuid]
        public ?string $parentCategoryId,
    ) {
    }
}
