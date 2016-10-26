<?php

namespace XTeam\SlackMessengerBundle\Provider;

use CL\Slack\Model\MessageResultItem;
use CL\Slack\Model\SimpleMessage;
use CL\Slack\Payload\ChannelsHistoryPayload;
use CL\Slack\Payload\ChannelsListPayload;
use CL\Slack\Payload\FilesInfoPayload;
use CL\Slack\Payload\SearchMessagesPayload;
use CL\Slack\Transport\ApiClientInterface;
use XTeam\SlackMessengerBundle\Adapter\SimpleMessageAdapter;
use XTeam\SlackMessengerBundle\Builder\MessageBuilderInterface;
use XTeam\SlackMessengerBundle\Exception\SlackApiException;

class SlackApiMessageProvider
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

    /**
     * @return bool True if the request was handled successfully, false otherwise
     */
    public function search($query, $sort = 'timestamp', $sortDir = 'desc', $perPage = 1000)
    {
        $payload = new SearchMessagesPayload();
        $payload->setQuery($query);
        $payload->setPage($perPage);
        $payload->setSort($sort);
        $payload->setSortDir($sortDir);

        $response = $this->apiClient->send($payload);

        if ($response->isOk()) {
            return array_filter(
                array_map(function (MessageResultItem $message) {
                    try {
                        return $this->messageBuilder->getMessage($message);
                    } catch (\Exception $e) {
                        return null;
                    }
                }, $response->getResult()->getMatches()),
                function ($message) {
                    return null !== $message;
                }
            );
        } else {
            throw new SlackApiException($response->getError());
        }
    }

    public function getFileInfo($fileUrl)
    {
        $fileId = explode('/', $fileUrl)[5];
        $fileId = 'F2SS1SBK6';
        $file = new FilesInfoPayload();
        $file->setFileId($fileId);

        $file = $this->apiClient->send($file)->getFile();

        return $file;
    }

    public function getMessagesFromAllChannels($sinceTimestamp = null, $allowedChannels = [])
    {
        $allMessages = [];
        $payload = new ChannelsListPayload();
        $channels = $this->apiClient->send($payload)->getChannels();

        foreach ($channels as $channel) {
            if (!empty($allowedChannels) && !in_array($channel->getName(), $allowedChannels)) {
                continue;
            }
            $channelPayload = new ChannelsHistoryPayload();
            $channelPayload->setChannelId($channel->getId());
            $channelPayload->setCount(100000);

            if (null !== $sinceTimestamp) {
                $channelPayload->setOldest($sinceTimestamp);
            }

            $messages = $this->apiClient->send($channelPayload)->getMessages();

            $allMessages = array_merge($allMessages, array_map(function (SimpleMessage $message) use ($channel) {
                return $this->messageBuilder->getMessage(new SimpleMessageAdapter($message, $channel));
            }, $messages));
        }

        return $allMessages;
    }

}
