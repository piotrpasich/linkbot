<?php

namespace XTeam\HighFiveSlackBundle\Chart;

use CpChart\Classes\pData;
use CpChart\Services\pChartFactory;
use XTeam\HighFiveSlackBundle\Adapter\PChartAdapter;
use XTeam\HighFiveSlackBundle\Entity\HighFiveRepository;
use XTeam\HighFiveSlackBundle\Statistic\HighFivesCollection;

class HighFiveChartDrawer implements ChartDrawerInterface
{
    public function draw(HighFivesCollection $highFivesCollection)
    {
        $factory = new pChartFactory();
        $myData = new pData();
        $pChartAdapter = new PChartAdapter();

        if ( ! empty($pChartAdapter->getData($highFivesCollection))) {
            foreach ($pChartAdapter->getData($highFivesCollection) as $key => $data) {
                $myData->addPoints($data, $key);
            }

            $myData->addPoints($highFivesCollection->getKeys(), "Options");
        } else {
            $myData->addPoints(VOID);
        }

        $myData->setAbscissa("Options");
        // create the image and set the data
        $chart = $factory->newImage(900, 380, $myData);
        $chart->drawLegend(800,30);
        $chart->setGraphArea(60, 40, 870, 290);

        $chart->drawText(10, 23, "High Fives");

        $chart->drawScale([
            "Factors" => [10000],
            'LabelRotation' => 45,
            'Mode' => SCALE_MODE_START0
        ]);

        $chart->drawStackedBarChart([
            "Floating0Serie" => "Floating 0",
            "Surrounding" => 10
        ]);

        return $chart;
    }
}