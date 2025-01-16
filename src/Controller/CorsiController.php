<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CorsiController extends AbstractController
{
    #[Route('/corsi', name: 'app_corsi')]
    public function index(): Response
    {
        return $this->render('pages/corsi/index.html.twig', [
            'controller_name' => 'CorsiController',
        ]);
    }
}
