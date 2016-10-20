<?php

namespace XTeam\HighFiveSlackBundle\Entity;

interface UserRepositoryInterface
{
    public function getOneById($id);
}