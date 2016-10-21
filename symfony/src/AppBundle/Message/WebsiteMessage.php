<?php

namespace AppBundle\Message;

use AppBundle\Entity\Link;

class WebsiteMessage extends MessageDecorator
{
    /**
     * @var Link
     */
    private $link;

    public function __construct(Link $link, MessageDecorator $messageDecorator = null)
    {
        parent::__construct($messageDecorator);
        $this->link = $link;
        var_dump($link);die();
    }

    public function getMessage()
    {
        $message = '';

        if (null != $this->messageDecorator) {
            $message = $this->messageDecorator->getMessage();
        }

        $url = $this->link->getLink();


    }

}