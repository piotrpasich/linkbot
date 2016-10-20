<?php

namespace XTeam\HighFiveSlackBundle\Entity\DataManipulator;


interface PeriodTypeInterface
{

    /**
     * @return String
     */
    public function getStartDate();

    /**
     * @return String
     */
    public function getEndDate();

}
