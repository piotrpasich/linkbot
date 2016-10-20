<?php

namespace XTeam\HighFiveSlackBundle\Statistic;

use XTeam\HighFiveSlackBundle\Entity\HighFive;

interface HighFiveStatisticInterface
{

    public function add(HighFive $highFive);

    public function getStats();

    public function getKey();
}