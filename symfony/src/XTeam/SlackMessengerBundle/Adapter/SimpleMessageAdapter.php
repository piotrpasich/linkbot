<?php

namespace XTeam\SlackMessengerBundle\Adapter;


use CL\Slack\Model\Channel;
use CL\Slack\Model\SimpleMessage;

class SimpleMessageAdapter extends SimpleMessage
{

    /**
     * @var string
     */
    protected $ts;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var SimpleChannel
     */
    private $channel;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $text;


    public function __construct(SimpleMessage $simpleMessage, Channel $channel)
    {
        $this->ts = $simpleMessage->getSlackTimestamp();
        $this->type = $simpleMessage->getType();
        $this->channel = $channel;
        $this->user = $simpleMessage->getUserId() ?: 'undefined';
        $this->username = $simpleMessage->getUsername() ?: 'undefined';
        $this->text = $simpleMessage->getText();
    }

    /**
     * @return SimpleChannel
     */
    public function getChannel()
    {
        return $this->channel;
    }
}
