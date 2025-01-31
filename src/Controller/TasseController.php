<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TasseController extends AbstractController
{
    #[Route('/tasse', name: 'app_tasse')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');

        $tasse = $this->getUser()->getStudente()->getTasse();


        return $this->render('pages/tasse/index.html.twig', [
            'controller_name' => 'TasseController',
        ]);
    }
}
