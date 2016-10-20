<?php

namespace XTeam\HighFiveSlackBundle\Statistic;

use XTeam\HighFiveSlackBundle\Statistic\CollectingStrategy\CollectingStrategyInterface;

class HighFivesCollection extends \ArrayIterator
{

    private $stats;

    public function __construct(array $highFives = [], CollectingStrategyInterface $collectingStrategy)
    {
        $this->stats = [];

        foreach ($highFives as $highFive) {
            $statKeysObjects = $highFive->{$collectingStrategy->getKeyMethodName()}();

            foreach ($statKeysObjects as $statKeyObject) {
                $statKey = $statKeyObject->getId();
                if (!isset($this->stats[$statKey])) {
                    $className = $collectingStrategy->getStatisticClassName();
                    $this->stats[$statKey] = new $className($statKeyObject);
                }

                $this->stats[$statKey]->add($highFive);
            }
        }

        parent::__construct($this->stats);
    }

    public function getKeys()
    {
        return array_map(function($stat) {
            return $stat->getKey();
        }, $this->stats);
    }

}
