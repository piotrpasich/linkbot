<?php

namespace XTeam\HighFiveSlackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use XTeam\HighFiveSlackBundle\Chart\ChartDrawerInterface;
use XTeam\HighFiveSlackBundle\Entity\DataManipulator\Period;
use XTeam\HighFiveSlackBundle\Entity\HighFiveRepository;

class ChartController extends Controller
{
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var ChartDrawerInterface
     */
    private $chartDrawer;

    /**
     * @var HighFiveRepository
     */
    private $highFiveRepository;

    public function __construct(TraceableEventDispatcher $eventDispatcher,
                                ChartDrawerInterface $chartDrawer,
                                HighFiveRepository $highFiveRepository)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->chartDrawer = $chartDrawer;
        $this->highFiveRepository = $highFiveRepository;
    }

    public function showAction(Request $request, $period = null)
    {
        $highFives = $this->highFiveRepository->getUserStats(new Period($period, $request->attributes->all()));
        $chart = $this->chartDrawer->draw($highFives);

        //catch the image
        ob_start();
        $chart->Stroke();
        $image_data = ob_get_contents();
        ob_end_clean();

        return new Response(
            $image_data,
            200,
            ['Content-Type'     => 'image/png',
             'Content-Disposition' => 'inline; filename="chart.png"']
        );
    }
}
