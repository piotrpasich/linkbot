<?php

namespace XTeam\HighFiveSlackBundle\Mapper;

use XTeam\HighFiveSlackBundle\Builder\ChannelEntityBuilder;
use XTeam\HighFiveSlackBundle\Builder\UserEntityBuilder;
use XTeam\HighFiveSlackBundle\Entity\Channel;
use XTeam\HighFiveSlackBundle\Entity\HighFive;
use XTeam\HighFiveSlackBundle\Entity\User;
use XTeam\HighFiveSlackBundle\Message\Parser\MentionsMessageParser;
use XTeam\HighFiveSlackBundle\Message\Parser\TypeMessageParser;
use XTeam\SlackMessengerBundle\Model\Message;

class HighFiveMapper
{

    /**
     * @var UserEntityBuilder
     */
    private $userEntityBuilder;

    /**
     * @var ChannelEntityBuilder
     */
    private $channelEntityBuilder;

    /**
     * @var MentionsMessageParser
     */
    private $mentionsMessageParser;

    /**
     * @var TypeMessageParser
     */
    private $typeMessageParser;

    public function __construct(
        UserEntityBuilder $userEntityBuilder,
        ChannelEntityBuilder $channelEntityBuilder,
        MentionsMessageParser $mentionsMessageParser,
        TypeMessageParser $typeMessageParser
    )
    {
        $this->userEntityBuilder = $userEntityBuilder;
        $this->channelEntityBuilder = $channelEntityBuilder;
        $this->mentionsMessageParser = $mentionsMessageParser;
        $this->typeMessageParser = $typeMessageParser;
    }

    /**
     * @param Message $message
     * @return HighFive
     */
    public function getHighFive(Message $message)
    {
        $highFive  = $this->mapHighFive($message);
        $publisher = $this->userEntityBuilder->getUser($message->getUser());
        $channel   = $this->channelEntityBuilder->getChannel($message->getChannel());

        $highFive->setPublisher($publisher);
        $highFive->setChannel($channel);

        return $highFive;
    }

    private function mapHighFive(Message $message)
    {
        $highFive = new HighFive();

        $highFive->setType($this->typeMessageParser->parse($message->getText()));
        $highFive->setCreatedAt($message->getCreatedAt());

        foreach ($this->mentionsMessageParser->parse($message->getText()) as $receiver) {
            $highFive->addReceiver($receiver);
        }

        return $highFive;
    }
}