<?php

namespace App\Controller;

use App\Repository\DumpRepository;
use App\Repository\UserRepository;
use App\Service\SortAndLimitArray;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


class StatisticsController extends AbstractController
{
    /**
     * @Route("/admin/statistics/dumps", name="admin_statistics_dumps")
     */
    public function index(ChartBuilderInterface $chartBuilder, DumpRepository $dumpRepository, SortAndLimitArray $sortAndLimitArray, Request $request): Response
    {

        // get dump list
        $dumps= $dumpRepository->findAllByCreationDateDesc('ASC');
        
        // call service
        $queryDayLimit = $request->query->get("dayLimit");

        $dumpsByCreationDateForChart = $sortAndLimitArray->runService($dumps, $queryDayLimit);
        
        // get labels and data points for chart
        $labels = array_keys($dumpsByCreationDateForChart);
        $data = array_values($dumpsByCreationDateForChart);


        // set max value for abscisse
        $maxValue = round(max($data) * 1.1, 0);

        $charts = [];

        // build chart
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Dump creation timeline',
                    // 'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'tension' => 0,
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'yAxes' => [
                    ['ticks' => ['min' => 0, 'max' => $maxValue]],
                ],
            ],
            'responsive' => false,
            'title' => [
                'display' => true,
                'text' => 'Dump creation timeline'
    ]
        ]);

        $charts[] = $chart;

        return $this->render('admin/statistics/index.html.twig', [
            'charts' => $charts,
            'chartClass' => 'my-chart line-chart',
        ]);
    }

    /**
     * @Route("/admin/statistics/users", name="admin_statistics_users")
     */
    public function index2(ChartBuilderInterface $chartBuilder, UserRepository $userRepository): Response
    {
        
        // get dump list
        $users= $userRepository->findAll();

        // get creation date of each dump in 'd/m/Y' format and add it as key to $dumpsByCreationDate 
        // then count each dump with that date store the sum as value for that date
        $usersActivity['Activité sur le site'] = [];
        $usersActivity['Publication de dump'] = [];
        $usersActivity['Orgnaisation de campagnes de ramassage'] = [];
        $usersActivity['Inscription aux campagnes de ramassage'] = [];

        // get activity for each user
        foreach($users as $user){
            $key = $user->getUserAlias() . ' (id:' . $user->getId() .')';
            $usersActivity['Activité sur le site'][$key] = count($user->getDumps()) + count($user->getRemovals()) + count($user->getSubscribedRemoval());
            $usersActivity['Publication de dump'][$key] = count($user->getDumps());
            $usersActivity['Orgnaisation de campagnes de ramassage'][$key] = count($user->getRemovals());
            $usersActivity['Inscription aux campagnes de ramassage'][$key] = count($user->getSubscribedRemoval());
        }

        $charts = [];
        $chart = 'chart';
        $chartCount = 0;

        foreach($usersActivity as $key => $activityArray){
            // sort array values
            arsort($activityArray);
            $chartCount += 1;

            $chartnumber = $chart . $chartCount;

            $topFiveActiveUsers = array_slice($activityArray, 0, 5, true);
                
            // get labels and data points for chart
            $labels = array_keys($topFiveActiveUsers);
            $data = array_values($topFiveActiveUsers);
        
            // build chart
            $$chartnumber = $chartBuilder->createChart(Chart::TYPE_DOUGHNUT);
            $$chartnumber->setData([
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Top 5 active users',
                        'backgroundColor' => [
                            'rgb(15, 128, 87)',
                            'rgb(11, 49, 66)',
                            'rgb(156, 146, 163)',
                            'rgb(198, 82, 205)',
                            'rgb(214, 211, 240)',
                        ],
                        'data' => $data,
                    ],
                ],
                ]);
                
                $$chartnumber->setOptions([
                'responsive' => false,
                'title' => [
                            'display' => true,
                            'text' => $key
                ]
                ]);

                $charts[] = $$chartnumber;
        
        }


        return $this->render('admin/statistics/index.html.twig', [
            'charts' => $charts,
            'chartClass' => 'my-chart doughnut-chart',
        ]);
    }

}
