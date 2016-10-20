<?php

namespace XTeam\SlackMessengerBundle\Model;

class Message
{

    /**
     * @var Team
     */
    protected $team;

    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var String
     */
    protected $text;

    /**
     * @var String
     */
    protected $triggerWord;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    protected $ts;

    public function __construct(User $user, Team $team, Channel $channel, $text, $ts, $triggerWord = '', $createdAt = 'now')
    {
        $this->user = $user;
        $this->team = $team;
        $this->channel = $channel;
        $this->ts = $ts;
        $this->setText($text);
        $this->setTriggerWord($triggerWord);
        $this->setCreatedAt($createdAt);
    }

    public function getTeam()
    {
        return $this->team;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getText()
    {
        return $this->text;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getTriggerWord()
    {
        return $this->triggerWord;
    }

    protected function setText($text)
    {
        if (empty($text) || ! is_string($text)) {
            $text = '';
//            throw new \InvalidArgumentException("The text should be a string");
        }

        $this->text = $text;
    }

    protected function setTriggerWord($triggerWord)
    {
        if ( ! is_string($triggerWord)) {
            throw new \InvalidArgumentException("The trigger word should be a string");
        }

        $this->triggerWord = $triggerWord;
    }

    protected function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            $createdAt = new \DateTime($createdAt);
        }

        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getTs()
    {
        return $this->ts;
    }

}
