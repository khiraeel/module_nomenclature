<?php

namespace App\Controller;

use App\DTO\User\UserCreationDto;
use App\Entity\User;
use App\Service\UserService;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserController extends BaseController
{
    public function __construct(
        private UserService $userService,
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    #[Route('/hello', name: 'hello', methods: ['GET'])]
    public function hello(Request $request): Response
    {
        return $this->createResponseSuccess(['Hello']);
    }

    #[Route('/api/register', name: 'user_register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $data = $request->toArray();

        $dto = new UserCreationDto(
            $data['email'],
            $data['login'],
            $data['firstName'],
            $data['lastName'],
            $data['password'],
        );

        $user = $this->userService->registerUser($dto);
        if (!$user instanceof User) {
            return $this->createResponseBadRequest(['Unable to register user.']);
        }

        return $this->createResponseSuccess([
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }

    #[Route('/api/profile', name: 'user_profile', methods: ['GET'])]
    public function profile(UserInterface $user): Response
    {
        return $this->createResponseSuccess([
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
}
