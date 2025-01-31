<?php

namespace App\Controller;

use App\Entity\Corso;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/corsi')]
class CorsiController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('', name: 'app_corsi')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');

        // TODO: Ritornare tutti i corsi dell'utente loggato

        return $this->render('pages/corsi/index.html.twig', [
            'controller_name' => 'CorsiController',
        ]);
    }

    #[Route('/get/{id}', name: 'api_get_corso', requirements: ['id' => Requirement::DIGITS])]
    public function getCorso(int $id): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse([
            'status' => '401',
            'error' => 'Unauthorized',
            'message' => '',
        ]);
        $corso = $this->entityManager->getRepository(Corso::class)->getCorsoById($id);

        return new JsonResponse([
            'id' => $corso->getId(),
            'codice' => $corso->getCodice(),
            'nome' => $corso->getNome(),
            'cfu' => $corso->getCfu(),
            'docente' => $corso->getDocente(),
            'anno' => $corso->getAnnoSvolgimento(),
            'note' => $corso->getNote() ?? ''
        ]);
    }

    #[Route('/add', name: 'app_add_corso')]
    public function addCorso(string $id): string
    {
        return "";
    }
}
