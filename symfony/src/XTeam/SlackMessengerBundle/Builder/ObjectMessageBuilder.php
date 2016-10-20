<?php

namespace XTeam\SlackMessengerBundle\Builder;

use CL\Slack\Model\MessageResultItem;
use XTeam\SlackMessengerBundle\Builder\MessageBuilderInterface;
use XTeam\SlackMessengerBundle\Model\Channel;
use XTeam\SlackMessengerBundle\Model\Message;
use XTeam\SlackMessengerBundle\Model\Team;
use XTeam\SlackMessengerBundle\Model\User;

class ObjectMessageBuilder implements MessageBuilderInterface
{
    /**
     * @param MessageResultItem $rawPayloadData
     * @return Message
     */
    public function getMessage($rawPayloadData)
    {
        return new Message(
            $this->getUser($rawPayloadData),
            $this->getTeam($rawPayloadData),
            $this->getChannel($rawPayloadData),
            $rawPayloadData->getText(),
            $rawPayloadData->getSlackTimestamp(),
            '',
            (new \DateTime())->setTimestamp($rawPayloadData->getSlackTimestamp())
        );
    }

    /**
     * @param MessageResultItem $rawPayloadData
     * @return MessageResultItem User
     */
    protected function getUser($rawPayloadData)
    {
        return new User(
            $rawPayloadData->getUserId(),
            $rawPayloadData->getUserName()
        );
    }

    /**
     * @param MessageResultItem $rawPayloadData
     * @return Channel
     */
    protected function getChannel($rawPayloadData)
    {
        return new Channel(
            $rawPayloadData->getChannel()->getId(),
            $rawPayloadData->getChannel()->getName()
        );
    }

    /**
     * @param MessageResultItem $rawPayloadData
     * @return Team
     */
    protected function getTeam($rawPayloadData)
    {
        return new Team(
            '???',
            '???'
        );
    }
}
