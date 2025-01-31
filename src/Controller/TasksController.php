<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TasksController extends AbstractController
{
    #[Route('/tasks', name: 'app_tasks')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');

        return $this->render('pages/tasks/index.html.twig', [
            'controller_name' => 'TasksController',
        ]);
    }
}
