<?php

namespace XTeam\HighFiveSlackBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ChannelRepository extends EntityRepository implements ChannelRepositoryInterface
{
    public function getOneById($id)
    {
        return parent::getOneBySlackId($id);
    }
}
