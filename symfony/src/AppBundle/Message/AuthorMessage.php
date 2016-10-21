<?php

namespace AppBundle\Message;

use AppBundle\Entity\Link;

class AuthorMessage extends MessageDecorator
{
    /**
     * @var Link
     */
    private $link;

    public function __construct(Link $link, MessageDecorator $messageDecorator = null)
    {
        parent::__construct($messageDecorator);
        $this->link = $link;
    }

    public function getMessage()
    {
        $message = '';

        if (null != $this->messageDecorator) {
            $message = $this->messageDecorator->getMessage();
        }

        $link = $this->link->getLink();

        return sprintf("[%s just published this on #%s]\n%s",
            $this->link->getUser()->getName(),
            $this->link->getChannel()->getName(),
            $this->link->getMessage()
            );
    }

}