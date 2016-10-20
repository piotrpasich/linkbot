<?php

namespace XTeam\HighFiveSlackBundle\Entity\DataManipulator;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class PeriodGuesser
{
    public function guess($periodParameter, $options = [])
    {
        $namespace = join('\\', array_slice(explode('\\', get_class($this)), 0, -1));

        $periodParameter = implode('', array_map(function ($periodParameter) {
            return ucfirst($periodParameter);
        }, explode('_', $periodParameter)));
        $className = $namespace . '\\' . $periodParameter . 'Period';

        if (!empty($periodParameter) && class_exists($className)) {
            return new $className($options);
        }

        return new LastWeekPeriod();
    }
}
