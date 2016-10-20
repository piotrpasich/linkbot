<?php

namespace XTeam\HighFiveSlackBundle\Chart;

use CpChart\Services\pChartFactory;
use XTeam\HighFiveSlackBundle\Entity\HighFiveRepository;
use XTeam\HighFiveSlackBundle\Statistic\HighFivesCollection;

interface ChartDrawerInterface
{
    public function draw(HighFivesCollection $highFivesCollection);

}