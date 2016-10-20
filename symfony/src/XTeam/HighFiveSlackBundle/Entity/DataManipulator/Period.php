<?php

namespace XTeam\HighFiveSlackBundle\Entity\DataManipulator;

use Doctrine\ORM\QueryBuilder;

class Period
{

    /**
     * @var PeriodTypeInterface
     */
    private $period;

    public function __construct($period = null, array $parameters = null)
    {
        $this->period = (new PeriodGuesser())->guess($period, $parameters);
    }

    public function manipulateQuery(QueryBuilder $query, $prefix = 'hv')
    {
        $query->where("$prefix.createdAt >= :startDate");
        $query->andWhere("$prefix.createdAt <= :endDate");
        $query->setParameters([
            'startDate' => $this->period->getStartDate(),
            'endDate' => $this->period->getEndDate()
        ]);

        return $query;
    }
}
