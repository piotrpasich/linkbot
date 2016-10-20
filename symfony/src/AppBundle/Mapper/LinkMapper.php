<?php

namespace AppBundle\Mapper;

use AppBundle\Entity\Link;
use XTeam\HighFiveSlackBundle\Builder\ChannelEntityBuilder;
use XTeam\HighFiveSlackBundle\Builder\UserEntityBuilder;
use XTeam\HighFiveSlackBundle\Entity\Channel;
use XTeam\HighFiveSlackBundle\Entity\HighFive;
use XTeam\HighFiveSlackBundle\Entity\User;
use XTeam\HighFiveSlackBundle\Message\Parser\MentionsMessageParser;
use XTeam\HighFiveSlackBundle\Message\Parser\TypeMessageParser;
use XTeam\SlackMessengerBundle\Model\Message;

class LinkMapper
{

    /**
     * @var UserEntityBuilder
     */
    private $userEntityBuilder;

    /**
     * @var ChannelEntityBuilder
     */
    private $channelEntityBuilder;

    public function __construct(
        UserEntityBuilder $userEntityBuilder,
        ChannelEntityBuilder $channelEntityBuilder
    )
    {
        $this->userEntityBuilder = $userEntityBuilder;
        $this->channelEntityBuilder = $channelEntityBuilder;
    }

    /**
     * @param Message $message
     * @return Link
     */
    public function getLink(Message $message)
    {
        $link  = $this->mapLink($message);
        $user = $this->userEntityBuilder->getUser($message->getUser());
        $channel   = $this->channelEntityBuilder->getChannel($message->getChannel());

        $link->setUser($user);
        $link->setChannel($channel);

        return $link;
    }

    private function mapLink(Message $message)
    {
        $link = new Link();

        $link->setCreatedAt($message->getCreatedAt());
        $link->setMessage($message->getText());
        $link->setLink($message->getText()); //@papi @todo
        $link->setSlackId($message->getTs() . $message->getChannel()->getId());

        return $link;
    }
}