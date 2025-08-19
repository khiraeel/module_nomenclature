<?php

namespace App\Service;

use App\DTO\User\UserCreationDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $hasher,
    ) {
    }

    public function registerUser(UserCreationDto $dto): ?User
    {
        $user = new User(
            $dto->email,
            $dto->login,
            $dto->firstName,
            $dto->lastName
        );

        $user->setPassword($this->hasher->hashPassword($user, $dto->password));

        $this->userRepository->add($user);

        $this->entityManager->flush();

        return $user;
    }
}
