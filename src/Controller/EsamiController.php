<?php

namespace App\Controller;

use App\Entity\Corso;
use App\Entity\Esame;
use App\Entity\Studente;
use App\Entity\Utente;
use App\HttpUtils\HttpError;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use function Webmozart\Assert\Tests\StaticAnalysis\boolean;

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

    /**
     * @throws \Exception
     */
    #[Route('/esami/add', name: 'api_add_esame')]
    public function add(
        Request $request,
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());
        $esame = new Esame();

        $nome = strip_tags($request->request->get("nome"));
        $dataSvolgimento = strip_tags($request->request->get("data_svolgimento"));

        $accettato = (boolean) strip_tags($request->request->get("accettazione"));
        $voto = (int)strip_tags($request->request->get("voto"));

        $corso = $this->entityManager->getRepository(Corso::class)->getCorsoById(
            (int)strip_tags($request->request->get('corso'))
        );

        // Lo studente è iscritto a questo corso
        if ($corso == null) return new JsonResponse(
            HttpError::BAD_REQUEST
                ->getWithCustomMessage("Lo studente non ha questo corso! Deve averlo per poter aggiungere l'esame")
        );

        // Voto e accettazione
        if ($accettato) {
            if (($voto < 18 || $voto > 31))
                return new JsonResponse(
                    HttpError::BAD_REQUEST
                        ->getWithCustomMessage("Il voto puo' essere accettato solo se è compreso tra 18 e 31 (30 lode)!")
                );
            $esame->setAccettato(true);
        } else $esame->setAccettato(false);

        $esame->setNome($nome);
        $esame->setDataSvolgimento($dataSvolgimento);
        $esame->setCorso($corso);
        $esame->setVoto($voto);
        $esame->setStudente($corso->getStudente());

        $corso->addEsame($esame);
        $this->entityManager->persist($esame);
        $this->entityManager->persist($corso);
        $this->entityManager->flush();

        return new JsonResponse([
            'status' => '200',
            'message' => 'Esame aggiunto',
            'id' => $esame->getId(),
        ]);
    }

    #[Route('/esami/feed_flcalendar', name: 'api_flcalendar')]
    public function feedFlCalendar(
        Request $request,
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

        $eventi = [];
        $studente = $this->entityManager->getRepository(Utente::class)->getUtenteByUsername($this->getUser()->getUserIdentifier())->getStudente();
        if ($studente == null) return new JsonResponse($eventi);


        $esami = $studente->getEsami();

        foreach ($esami as $esame) {
            $eventi[] = [
                "title" => $esame->getNome(),
                'start' => DateTime::createFromFormat('d/m/Y', $esame->getDataSvolgimento())->format('Y-m-d'),
                'allDay' => true
            ];
        }

        return new JsonResponse($eventi);
    }

    #[Route('/esami/accetta', name: 'api_accetta')]
    public function accetta(
        #[MapQueryParameter] ?int $id,
        #[MapQueryParameter] ?int $voto,
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());
        if ($id === null) return new JsonResponse(HttpError::BAD_REQUEST->getWithCustomMessage("Il parametro id deve essere valido per accettare il voto!"));

        $esame = $this->entityManager->getRepository(Esame::class)->getEsameById($id);

        // Esame non è stato accettato in precedenza, il voto nel range 18-31
        if (!$esame->isAccettato() and ($voto >17 and $voto < 32)) {
            $esame->setAccettato(true);
        }

        return new JsonResponse($esame->toArray());
    }
}
