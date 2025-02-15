<?php

namespace App\Controller;

use App\Entity\TodoList;
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

        $titolo = $request->request->get('titolo');


        //$todo = new TodoList();
        //$todo->setTitolo($titolo);

        return new JsonResponse(
            [
                "sdebrtrgezggtus" => 2323323200,
                "titolo" => $titolo
            ]
        );
    }
}
