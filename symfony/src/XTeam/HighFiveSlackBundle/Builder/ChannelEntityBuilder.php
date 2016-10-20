<?php

namespace XTeam\HighFiveSlackBundle\Builder;

use XTeam\HighFiveSlackBundle\Entity\ChannelRepositoryInterface;
use XTeam\SlackMessengerBundle\Model\Channel;
use XTeam\HighFiveSlackBundle\Entity\Channel as ChannelEntity;

class ChannelEntityBuilder
{

    /**
     * @var ChannelRepositoryInterface
     */
    private $channelRepository;

    private $savedRecords = [];

    public function __construct(ChannelRepositoryInterface $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function getChannel(Channel $channel)
    {
        if (!isset($this->savedRecords[(string)$channel->getId()]) || null == $this->savedRecords[(string)$channel->getId()]) {
            $this->savedRecords[(string)$channel->getId()] =  $this->channelRepository->findOneBySlackId((string)$channel->getId()) ?:
                (new ChannelEntity())
                    ->setName((string)$channel->getName())
                    ->setSlackId((string)$channel->getId());
        }

        return $this->savedRecords[(string)$channel->getId()];
    }
}
