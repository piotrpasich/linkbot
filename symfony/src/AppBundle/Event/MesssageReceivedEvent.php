<?php

namespace AppBundle\Event;

use XTeam\SlackMessengerBundle\Model\Message;
use Symfony\Component\EventDispatcher\Event;

class MesssageReceivedEvent extends Event
{
    const NAME = 'message.received';

    /**
     * @var Message
     */
    private $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

}