<?php

namespace AppBundle\Event;

use AppBundle\Entity\Link;
use Symfony\Component\EventDispatcher\Event;

class LinkSentEvent extends Event
{
    const NAME = 'message.sent';

    /**
     * @var Link
     */
    private $link;

    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * @return Link
     */
    public function getLink()
    {
        return $this->link;
    }

}