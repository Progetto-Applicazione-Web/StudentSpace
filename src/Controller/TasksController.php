<?php

namespace App\Controller;

use App\Entity\Task;
use App\HttpUtils\HttpError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tasks')]
class TasksController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'app_tasks')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');

        return $this->render('pages/tasks/index.html.twig', [
            'controller_name' => 'TasksController',
        ]);
    }

    #[Route('/edit', name: 'api_edit_tasks')]
    public function edit(
        Request $request,
    ): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

        $id = $request->get('id');
        $description = $request->get('description');
        $completato = $request->get('completato');

        $task = $this->entityManager->getRepository(Task::class)->getTaskById($id);

        if ($task == null)
            return new JsonResponse(HttpError::NOT_FOUNT->getWithCustomMessage("Non trovato task/edit?id=$id"));

        if ($description != "") $task->setDescrizione($description);
        if ($completato != "") $task->setCompletato($completato);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return new JsonResponse([
            "status" => 200,
            "message" => "Task modificato!"
        ]);
    }
}
