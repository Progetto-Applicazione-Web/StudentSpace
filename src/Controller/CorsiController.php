<?php

namespace App\Controller;

use App\Entity\Corso;
use App\Entity\Studente;
use App\Entity\Utente;
use App\HttpUtils\HttpError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

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

    #[Route('/add', name: 'api_add_corso')]
    public function addCorso(
        #[MapQueryParameter] string $nome = '',
        #[MapQueryParameter('anno_svolgimento')] string $annoSvolgimento = '',
        #[MapQueryParameter] string $codice = '',
        #[MapQueryParameter] string $docente = '',
        #[MapQueryParameter] int $cfu = 0,
        #[MapQueryParameter] string $note = ''

    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

        $nome = strip_tags($nome);
        $annoSvolgimento = strip_tags($annoSvolgimento);
        $codice = strip_tags($codice);
        $docente = strip_tags($docente);
        $note = strip_tags($note);

        $corso = new Corso();
        $corso
            ->setNome($nome)
            ->setAnnoSvolgimento($annoSvolgimento)
            ->setCodice($codice)
            ->setDocente($docente)
            ->setCfu($cfu)
            ->setNote($note);

        $studente = $this->entityManager->getRepository(Utente::class)->getUtenteByUsername($this->getUser()->getUserIdentifier())->getStudente();
        $studente->addcorso($corso);
        $this->entityManager->persist($corso);
        $this->entityManager->persist($studente);
        $this->entityManager->flush();

        return new JsonResponse([
            'status' => '200',
            'message' => 'Corso aggiunto',
            'id' => $corso->getId(),
        ]);
    }
}
