<?php

namespace XTeam\HighFiveSlackBundle\Entity;

use Doctrine\ORM\EntityRepository;
use XTeam\HighFiveSlackBundle\Entity\DataManipulator\Period;
use XTeam\HighFiveSlackBundle\Statistic\HighFivesCollection;
use XTeam\HighFiveSlackBundle\Statistic\CollectingStrategy\UserCollectingStrategy;

class HighFiveRepository extends EntityRepository
{

    /**
     * @return HighFivesCollection
     */
    public function getUserStats(Period $period = null)
    {
        $highFivesQueryBuilder = $this->createQueryBuilder('hv');

        if (null !== $period) {
            $highFivesQueryBuilder = $period->manipulateQuery($highFivesQueryBuilder);
        }

        $highFives = $highFivesQueryBuilder->getQuery()->getResult();

        return new HighFivesCollection($highFives, new UserCollectingStrategy());
    }

    public function getMatch($createdAt, $publisherId)
    {
        return $this->findOneBy([
            'createdAt' => $createdAt,
            'publisher' => $publisherId
        ]);
    }

    public function getLastTimeStamp()
    {
        $highFive = $this->createQueryBuilder('hv')
            ->select('hv.createdAt')
            ->setMaxResults(1)
            ->orderBy('hv.createdAt', 'DESC')
            ->getQuery()
            ->getArrayResult();

        if (empty($highFive)) {
            return null;
        }

        return $highFive[0]['createdAt']->getTimestamp();
    }
}
