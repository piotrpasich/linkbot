<?php

namespace XTeam\HighFiveSlackBundle\Entity\DataManipulator;


class YesterdayPeriod implements PeriodTypeInterface
{

    /**
     * @return String
     */
    public function getStartDate()
    {
        return (new \DateTime())
            ->sub(new \DateInterval('P1D'))
            ->setTime(0, 0, 1)
            ->format('Y-m-d H:i:s');
    }

    /**
     * @return String
     */
    public function getEndDate()
    {
        return (new \DateTime())
            ->sub(new \DateInterval('P1D'))
            ->setTime(23, 59, 59)
            ->format('Y-m-d H:i:s');
    }
}
