<?php

namespace XTeam\HighFiveSlackBundle\Statistic\CollectingStrategy;


class UserCollectingStrategy implements CollectingStrategyInterface
{

    public function getKeyMethodName()
    {
        return 'getReceivers';
    }

    public function getStatisticClassName()
    {
        return 'XTeam\HighFiveSlackBundle\Statistic\UserHighFiveStatistic';
    }

}