<?php

namespace App\Controller;

use App\Entity\Studente;
use App\Entity\Utente;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class VotiController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager,)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/voti', name: 'app_voti')]
    public function index(ChartBuilderInterface $chartBuilder): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED')) return $this->redirectToRoute('app_login');

        $votiPerMedia = $this->entityManager->getRepository(Studente::class)->getVotiPerMedia();
        // Grafico
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
            'datasets' => [
                [
                    'backgroundColor' => 'rgba(52, 105, 223, 0.2)', // Area sotto la linea
                    'borderColor' => '#3469DF', // Colore della linea
                    'data' => $votiPerMedia, // Dati compresi tra 18 e 31
                    'fill' => true, // Riempi sotto la linea
                ]
            ],
        ]);

        $chart->setOptions([
            'plugins' => [
                'legend' => [
                    'display' => false, // Nasconde la label e il rettangolino
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false, // Nasconde le linee verticali
                        
                    ],
                    'ticks' => [
                        'color' => '#D3D5EE', // Colore delle etichette
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
                'y' => [
                    'grid' => [
                        'color' => '#ECF4FF', // Colore delle linee orizzontali
                        'borderDash' => [], // Linea continua
                    ],
                    'ticks' => [
                        'stepSize' => 1, // Intervallo dei tick
                        'color' => '#3469DF', // Colore delle etichette
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                    'min' => 18, // Valore minimo
                    'max' => 32, // Valore massimo (oltre 31 per includere l'ultimo tick)
                ],
            ],
            'elements' => [
                'line' => [
                    'tension' => 0.4, // Linea curva
                    'borderWidth' => 4, // Spessore della linea
                ],
                'point' => [
                    'radius' => 0, // Rimuove i punti
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false, // Permette dimensioni personalizzate
        ]);
        

        return $this->render('pages/voti/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}
