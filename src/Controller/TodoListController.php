<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TodoList;
use App\Entity\Utente;
use App\HttpUtils\HttpError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/todolists')]
final class TodoListController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'app_todolists')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');

        throw $this->createNotFoundException();
    }

    #[Route('/add', name: 'api_add_todolist')]
    public function addTodoList(
        Request $request
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

        $titolo = strip_tags($request->request->get('titolo'));
        $tasksRaw = json_decode($request->request->get('tasks'));
        $todolist = new TodoList();
        $todolist->setTitolo($titolo);
        foreach ($tasksRaw as $descrizone) {
            $task = new Task();
            $task->setDescrizione($descrizone);
            $todolist->addTask($task);
        }

        $studente = $this->entityManager->getRepository(Utente::class)->getUtenteByUsername($this->getUser()->getUserIdentifier())->getStudente();
        $studente->addTodolist($todolist);
        $this->entityManager->persist($studente);
        $this->entityManager->flush();

        return new JsonResponse(
            [
                "status" => 200,
                "message" => "Todo list aggiunta",
                "id" => $todolist->getId()
            ]
        );
    }


    #[Route('/remove', name: 'api_remove_todolist')]
    public function removeTodoList(
        Request $request
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

        $id = $request->get('id');
        if (is_numeric($id)) return new JsonResponse(HttpError::BAD_REQUEST->getWithCustomMessage("L'id che hai passato non è valido, deve essere numerico!"));

        $todolist = $this->entityManager->getRepository(TodoList::class)->getTodoListById($id);

        if($todolist == null) return new JsonResponse(HttpError::NOT_FOUNT->getWithCustomMessage("Todo List non trovata!"));
        $idTodoList = $todolist->getId();

        $this->entityManager->remove($todolist);
        $this->entityManager->flush();

        return new JsonResponse(
            [
                "status" => 200,
                "message" => "Todo List rimossa",
                "id" => $idTodoList
            ]
        );
    }
}
