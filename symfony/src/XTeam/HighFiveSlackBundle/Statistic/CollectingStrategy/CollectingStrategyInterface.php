<?php

namespace XTeam\HighFiveSlackBundle\Statistic\CollectingStrategy;


interface CollectingStrategyInterface
{

    public function getKeyMethodName();

    public function getStatisticClassName();
}
