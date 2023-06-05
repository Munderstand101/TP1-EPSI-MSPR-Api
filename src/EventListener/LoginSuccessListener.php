<?php
// src/EventListener/LoginSuccessListener.php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

class LoginSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        /** @var UserInterface $user */
        $user = $event->getUser();

        // Retrieve user information
        $userInfo = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            // Add other user properties as needed
        ];

        // Generate JWT token
        $jwtToken = $event->getData()['token'];

        // Customize the login response
        $response = new JsonResponse([
            'user' => $userInfo,
            'token' => $jwtToken,
        ]);

        return $response;
    }
}
