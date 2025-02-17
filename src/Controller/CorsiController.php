<?php

namespace App\Controller;

use App\Entity\Corso;
use App\Entity\StatoCorso;
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



        return $this->render('pages/corsi/index.html.twig', [
            'controller_name' => 'CorsiController',
            'stati_possibili_corso' => $this->entityManager->getRepository(StatoCorso::class)->findAll()
        ]);
    }

    #[Route('/get', name: 'api_get_corso', requirements: ['id' => Requirement::DIGITS])]
    public function getCorso(
        Request $request,
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());
        $id = $request->get('id');
        if (!is_numeric($id)) return new JsonResponse(HttpError::BAD_REQUEST->getWithCustomMessage("L'id del corso non è valido!"));
        $corso = $this->entityManager->getRepository(Corso::class)->getCorsoById((int)$id);
        return !($corso == null) ? new JsonResponse($corso->toArray()) : new JsonResponse();
    }

    #[Route('/add', name: 'api_add_corso')]
    public function addCorso(
        Request $request
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

        $icona = $request->get("icona");
        $nome = strip_tags($request->get("nome"));
        $codice = strip_tags($request->get("codice"));
        $cfu = strip_tags($request->get("cfu"));
        $docente = strip_tags($request->get("docente"));
        $annoSvolgimento = strip_tags($request->get("anno_svolgimento"));
        $note = strip_tags($request->get("note"));
        $statoId = (int)strip_tags($request->get("stato_id"));

        // Controllo se lo stato esiste
        $stato = $this->entityManager->getRepository(StatoCorso::class)->findOneBy(['id' => $statoId]);
        if ($stato == null) return new JsonResponse(HttpError::BAD_REQUEST->getWithCustomMessage("Lo stato del corso che hai passato non é valido!"));

        $corso = new Corso();
        $corso
            ->setIcona($icona)
            ->setNome($nome)
            ->setAnnoSvolgimento($annoSvolgimento)
            ->setCodice($codice)
            ->setDocente($docente)
            ->setCfu($cfu)
            ->setStato($stato)
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

    #[Route('/edit', name: 'api_edit_corso')]
    public function editCorso(
        Request $request
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

        $id = $request->get("id");
        $icona = $request->get("icona");
        $nome = strip_tags($request->get("nome"));
        $codice = strip_tags($request->get("codice"));
        $cfu = strip_tags($request->get("cfu"));
        $docente = strip_tags($request->get("docente"));
        $annoSvolgimento = strip_tags($request->get("anno_svolgimento"));
        $note = strip_tags($request->get("note"));
        $statoId = (int)strip_tags($request->get("stato_id"));

        if ($id === null) return new JsonResponse(HttpError::BAD_REQUEST->getWithCustomMessage("Il parametro id deve essere valido per poter modificare il corso!"));


        $corso = $this->entityManager->getRepository(Corso::class)->getCorsoById($id);

        if ($corso == null)
            return new JsonResponse(HttpError::NOT_FOUNT->getWithCustomMessage("Non trovato corsi/edit?id=$id"));


        if ($nome != null) $corso->setNome($nome);
        if ($annoSvolgimento != null) $corso->setAnnoSvolgimento($annoSvolgimento);
        if ($codice != null) $corso->setCodice($codice);
        if ($docente != null) $corso->setDocente($docente);
        if ($cfu != null) $corso->setCfu($cfu);
        if ($note != null) $corso->setNote($note);

        $this->entityManager->persist($corso);
        $this->entityManager->flush();

        return new JsonResponse([
            'status' => '200',
            'message' => 'Corso aggiornato',
            'id' => $corso->getId(),
        ]);
    }

}
