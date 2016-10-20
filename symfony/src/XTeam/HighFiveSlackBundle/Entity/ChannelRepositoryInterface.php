<?php

namespace XTeam\HighFiveSlackBundle\Entity;

interface ChannelRepositoryInterface
{
    public function getOneById($id);
}