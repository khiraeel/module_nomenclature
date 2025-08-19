<?php

namespace App\DTO\Product;

use App\Interface\JsonBodyDtoRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ProductUpdateImageDto implements JsonBodyDtoRequestInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'ID cannot be blank.')]
        #[Assert\Uuid(message: 'Invalid UUID format.')]
        public string $id,
        #[Assert\NotBlank(message: 'File URL cannot be blank!')]
        #[Assert\Url(message: 'This value is not a valid image URL!')]
        public string $file_url,
    ) {
    }
}
