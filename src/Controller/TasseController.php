<?php

namespace App\Controller;

use App\Entity\Tassa;
use App\Entity\Utente;
use App\HttpUtils\HttpError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Webmozart\Assert\Tests\StaticAnalysis\boolean;

#[Route('/tasse', name: '')]
class TasseController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('', name: 'app_tasse')]
    public function index(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');


        return $this->render('pages/tasse/index.html.twig', [
            'controller_name' => 'TasseController',
        ]);
    }

    #[Route('/add', name: 'api_add_tasse')]
    public function add(
        Request $request,
    ): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return new JsonResponse(HttpError::UNAUTHORIZED->getJsonMessage());

        $importo = (double)strip_tags($request->get('importo'));
        $scadenza = strip_tags($request->get('scadenza'));
        $descrizione = strip_tags($request->get('descrizione'));
        strip_tags($request->get('pagato'));
        $isPagato = strip_tags($request->get('pagato')) === "true";
        $dataPagamento = strip_tags($request->get('dataPagamento'));

        $tassa = new Tassa();
        if (($importo <= 0 || $dataPagamento == "") and $isPagato) {
            return new JsonResponse(HttpError::BAD_REQUEST->getWithCustomMessage("Se hai pagato fammi sapere quando e quanto :)"));
        }

        $tassa = new Tassa();
        if ($isPagato) {
            $tassa
                ->setImporto($importo)
                ->setDataPagamento($dataPagamento)
                ->setPagato(true);
        }
        $tassa
            ->setImporto($importo)
            ->setDataScadenza($scadenza)
            ->setDescrizione($descrizione);

        $studente = $this->entityManager->getRepository(Utente::class)->getUtenteByUsername($this->getUser()->getUserIdentifier())->getStudente();
        $tassa->setStudente($studente);
        $this->entityManager->persist($tassa);
        $this->entityManager->flush();

        return new JsonResponse([
            'status' => '200',
            'message' => 'Tassa aggiunta',
            'id' => $tassa->getId(),
        ]);
    }
}
