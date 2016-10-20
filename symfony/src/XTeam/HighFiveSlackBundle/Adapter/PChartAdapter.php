<?php

namespace XTeam\HighFiveSlackBundle\Adapter;


use XTeam\HighFiveSlackBundle\Statistic\HighFivesCollection;

class PChartAdapter
{

    public function getData(HighFivesCollection $highFivesCollection)
    {
        $types = $this->getAllTypes($highFivesCollection);
        $preparedData = [];

        foreach ($highFivesCollection as $key => $highFiveStat) {
            foreach ($types as $type) {
                if (isset($highFiveStat->getStats()[$type])) {
                    $preparedData[$type][] = $highFiveStat->getStats()[$type];
                } else {
                    $preparedData[$type][] = 0;
                }
            }
        }

        return $preparedData;
    }

    protected function getAllTypes(HighFivesCollection $highFivesCollection)
    {
        $types = [];

        foreach ($highFivesCollection as $key => $highFiveStat) {
            $types = array_merge($types, array_keys($highFiveStat->getStats()));
        }

        $types = array_unique($types);

        sort($types);

        return $types;
    }
}
