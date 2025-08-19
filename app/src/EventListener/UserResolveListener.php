<?php

namespace App\EventListener;

use App\Entity\User;
use App\Repository\UserRepository;
use League\Bundle\OAuth2ServerBundle\Event\UserResolveEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserResolveListener
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $userPasswordEncoder,
    ) {
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        $user = $this->userRepository->getUserEntityByUserCredentials(
            $event->getUsername(),
            $event->getPassword(),
            $event->getGrant(),
            $event->getClient()
        );

        if (!$user instanceof User) {
            return;
        }

        if (!$this->userPasswordEncoder->isPasswordValid($user, $event->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}
