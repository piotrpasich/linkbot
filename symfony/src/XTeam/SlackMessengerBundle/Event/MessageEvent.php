<?php

namespace XTeam\SlackMessengerBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use XTeam\SlackMessengerBundle\Model\Message;

class MessageEvent extends Event
{

    /**
     * @var Message
     */
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
