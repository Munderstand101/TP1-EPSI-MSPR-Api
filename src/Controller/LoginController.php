<?php
// src/Controller/LoginController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class LoginController extends AbstractController
{
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    /**
     * @Route("/api/login", name="app_login", methods={"POST"})
     */
    public function login(Request $request)
    {
        /** @var UserInterface $user */
        $user = $this->getUser();

        // Retrieve user information
        $userInfo = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            // Add other user properties as needed
        ];

        // Generate JWT token
        $jwtToken = $this->jwtManager->create($user);

        // Customize the login response
        $response = new JsonResponse([
            'user' => $userInfo,
            'token' => $jwtToken,
        ]);

        return $response;
    }
}
