<?php

namespace AppBundle\EventListener;

use AppBundle\Event\LinkSentEvent;
use AppBundle\Mapper\LinkMapper;
use AppBundle\Message\WebsiteMessage;
use AppBundle\Repository\LinkRepository;
use AppBundle\Voter\LinkVoter;
use CL\Slack\Payload\ChatPostMessagePayload;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use XTeam\SlackMessengerBundle\Publisher\SlackApiMessagePublisher;

class MessageSendEventListener
{

    /**
     * @var SlackApiMessagePublisher
     */
    private $apiMessagePublisher;

    /**
     * @var array
     */
    private $configuration;

    public function __construct(SlackApiMessagePublisher $apiMessagePublisher, $configuration)
    {
        $this->apiMessagePublisher = $apiMessagePublisher;
        $this->configuration = $configuration;
    }

    public function sentMessage(LinkSentEvent $linkSentEvent)
    {
        $link = $linkSentEvent->getLink();

        $payload = new ChatPostMessagePayload();
        $payload->setChannel($this->configuration['publish_channel']);
        $payload->setUsername($this->configuration['name']);

        $message = new WebsiteMessage($link);
        $payload->setText($message->getMessage());

        $this->apiMessagePublisher->publish($payload);
    }
}
