<?php

namespace AppBundle\Message;

abstract class MessageDecorator
{

    /**
     * @var MessageDecorator
     */
    protected $messageDecorator;

    public function __construct(MessageDecorator $messageDecorator = null)
    {
        $this->messageDecorator = $messageDecorator;
    }

    abstract public function getMessage();

}