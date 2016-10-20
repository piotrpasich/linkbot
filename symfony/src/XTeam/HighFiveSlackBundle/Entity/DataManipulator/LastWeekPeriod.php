<?php

namespace XTeam\HighFiveSlackBundle\Entity\DataManipulator;


class LastWeekPeriod implements PeriodTypeInterface
{

    /**
     * @return String
     */
    public function getStartDate()
    {
        return (new \DateTime())
            ->sub(new \DateInterval('P7D'))
            ->format('Y-m-d H:i:s');
    }

    /**
     * @return String
     */
    public function getEndDate()
    {
        return (new \DateTime())->format('Y-m-d H:i:s');
    }
}
