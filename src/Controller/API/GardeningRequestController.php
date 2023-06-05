<?php

namespace App\Controller\API;

use App\Entity\Gardening;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GardeningRequestController extends AbstractController
{
    #[Route('/gardening/request', name: 'app_gardening_request')]
    public function createGardeningRequest(Request $request): Response
    {
        // Vérifiez et validez les données de la demande

//        $gardeningRequest = new Gardening();
//        $gardeningRequest->setUser($this->getUser());
//        $gardeningRequest->setPlant($plant);

        // Enregistrez la demande de garde dans la base de données

        return $this->json(['message' => 'Gardening request created successfully'], Response::HTTP_CREATED);
    }
}
