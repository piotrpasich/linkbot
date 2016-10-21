<?php

namespace AppBundle\Voter;


use AppBundle\Entity\Link;

class LinkVoter
{
    public function supports(Link $link)
    {
        return ! empty($link->getLink());
    }
}