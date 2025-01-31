<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EsamiController extends AbstractController
{
    #[Route('/esami', name: 'app_esami')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');

        return $this->render('pages/esami/index.html.twig', [
            'controller_name' => 'EsamiController',
        ]);
    }
}
