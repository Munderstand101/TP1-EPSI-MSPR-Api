<?php

namespace App\Controller\APP;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_maintenance')]
    public function maintenance(): Response
    {
        return $this->render('main/maintenance.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/app/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}
