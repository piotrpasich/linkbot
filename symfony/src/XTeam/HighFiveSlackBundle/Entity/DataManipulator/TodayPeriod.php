<?php

namespace XTeam\HighFiveSlackBundle\Entity\DataManipulator;


class TodayPeriod implements PeriodTypeInterface
{

    /**
     * @return String
     */
    public function getStartDate()
    {
        return (new \DateTime())
            ->setTime(0, 0, 1)
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
