<?php

namespace App\DTO\User;

readonly class UserCreationDto
{
    public function __construct(
        public string $email,
        public string $login,
        public string $firstName,
        public string $lastName,
        public string $password,
    ) {
    }
}
