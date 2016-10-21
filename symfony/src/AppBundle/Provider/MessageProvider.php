<?php

namespace AppBundle\Provider;


use AppBundle\Entity\Link;
use CL\Slack\Payload\ReactionsPayload;
use CL\Slack\Transport\ApiClientInterface;
use XTeam\SlackMessengerBundle\Builder\MessageBuilderInterface;

class MessageProvider
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    /**
     * @var SlackAPIMessageBuilder
     */
    protected $messageBuilder;

    public function __construct(ApiClientInterface $apiClient, MessageBuilderInterface $messageBuilder)
    {
        $this->apiClient = $apiClient;
        $this->messageBuilder = $messageBuilder;
    }

    public function getReactions(Link $link)
    {
        $payload = new ReactionsPayload();
        $payload->setChannelId($link->getChannel()->getSlackId());
        $payload->setTimestamp($link->getSlackTS());

        return $this->apiClient->send($payload)->getReactions();
    }
}