<?php

namespace XTeam\SlackMessengerBundle\Publisher;

use CL\Slack\Payload\ChatPostMessagePayload;
use CL\Slack\Transport\ApiClientInterface;

class SlackApiMessagePublisher
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    public function __construct(ApiClientInterface $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param String $channel
     * @param String $message
     * @return bool True if the request was handled successfully, false otherwise
     */
    public function publish($channel, $message)
    {
        $payload = new ChatPostMessagePayload();
        $payload->setChannel($channel);
        $payload->setText($message);

        /** @var \CL\Slack\Payload\ChatPostMessagePayloadResponse $response */
        $response = $this->apiClient->send($payload);

        return $response->isOk();
    }

    public function publishPayload(ChatPostMessagePayload $payload)
    {
        /** @var \CL\Slack\Payload\ChatPostMessagePayloadResponse $response */
        $response = $this->apiClient->send($payload);

        return $response->isOk();
    }
}
