<?php

namespace XTeam\HighFiveSlackBundle\Statistic;

use XTeam\HighFiveSlackBundle\Entity\HighFive;
use XTeam\HighFiveSlackBundle\Entity\User;

class UserHighFiveStatistic implements HighFiveStatisticInterface
{

    private $stats = [];

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function add(HighFive $highFive)
    {
        if ( ! isset($this->stats[$highFive->getType()->getName()])) {
            $this->stats[$highFive->getType()->getName()] = 0;
        }

        $this->stats[$highFive->getType()->getName()] += 1;
    }

    public function getStats()
    {
        return $this->stats;
    }

    public function getKey()
    {
        return $this->user->getName();
    }
}