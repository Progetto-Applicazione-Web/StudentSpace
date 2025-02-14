<?php

namespace App\Controller;

use App\Entity\Corso;
use App\Entity\Esame;
use App\HttpUtils\HttpError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class EsamiController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/esami', name: 'app_esami')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');

        return $this->render('pages/esami/index.html.twig', [
            'controller_name' => 'EsamiController',
        ]);
    }

    #[Route('/esami/accetta', name: 'api_accetta')]
    public function accetta(
        #[MapQueryParameter] ?int $id,
        #[MapQueryParameter] ?int $voto,
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse([]);
        if ($id === null) return new JsonResponse(HttpError::BAD_REQUEST->getWithCustomMessage("Il parametro id deve essere valido per accettare il voto!"));

        $esame = $this->entityManager->getRepository(Esame::class)->getEsameById($id);

        // Esame non è stato accettato in precedenza, il voto nel range 18-31
        if (!$esame->isAccettato() and ($voto >17 and $voto < 32)) {
            $esame->setAccettato(true);
        }

        return new JsonResponse($esame->toArray());
    }
}
