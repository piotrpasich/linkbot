<?php

namespace XTeam\SlackMessengerBundle\Builder;

use XTeam\SlackMessengerBundle\Builder\MessageBuilderInterface;
use XTeam\SlackMessengerBundle\Model\Channel;
use XTeam\SlackMessengerBundle\Model\Message;
use XTeam\SlackMessengerBundle\Model\Team;
use XTeam\SlackMessengerBundle\Model\User;

class SlackAPIMessageBuilder implements MessageBuilderInterface
{

    public function getMessage($rawPayloadData)
    {
        return new Message(
            $this->getUser($rawPayloadData),
            $this->getTeam($rawPayloadData),
            $this->getChannel($rawPayloadData),
            $rawPayloadData['text'],
            $rawPayloadData['trigger_word']
        );
    }

    protected function getUser(array $rawPayloadData)
    {
        return new User(
            $rawPayloadData['user_id'],
            $rawPayloadData['user_name']
        );
    }

    protected function getChannel(array $rawPayloadData)
    {
        return new Channel(
            $rawPayloadData['channel_id'],
            $rawPayloadData['channel_name']
        );
    }

    protected function getTeam(array $rawPayloadData)
    {
        return new Team(
            $rawPayloadData['team_id'],
            $rawPayloadData['team_domain']
        );
    }
}
