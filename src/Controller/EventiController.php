<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventiController extends AbstractController
{
    #[Route('/eventi', name: 'app_eventi')]
    public function index(): Response
    {
        return $this->render('/pages/eventi/index.html.twig', [
            'controller_name' => 'EventiController',
        ]);
    }
}
