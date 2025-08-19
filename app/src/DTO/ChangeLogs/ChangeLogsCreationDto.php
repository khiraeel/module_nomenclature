<?php

namespace App\DTO\ChangeLogs;

use App\Interface\JsonBodyDtoRequestInterface;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ChangeLogsCreationDto implements JsonBodyDtoRequestInterface
{
    public function __construct(
        #[Assert\NotBlank]
        public string $entityType,
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $entityId,
        #[Assert\NotBlank]
        #[Assert\Json]
        public string $changes,
    ) {
    }
}
