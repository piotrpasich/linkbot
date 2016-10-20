<?php

namespace XTeam\HighFiveSlackBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    public function getOneById($id)
    {
        return parent::findOneById($id);
    }
}
