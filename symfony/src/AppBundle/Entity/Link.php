<?php

namespace AppBundle\Entity;
use XTeam\HighFiveSlackBundle\Entity\Channel;
use XTeam\HighFiveSlackBundle\Entity\User;


/**
 * Link
 */
class Link
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \stdClass
     */
    private $user;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $link;

    /**
     * @var \DateTime
     */
    private $createdAt;

    private $channel;

    private $slackId;

    private $sent = false;
    /**
     * @var Slack TimeStamp
     */
    private $slackTS;

    /**
     * @var int
     */
    private $reactionsCount = 0;

    private $linkInfo;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return Link
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Link
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Link
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Link
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return Channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param mixed $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return mixed
     */
    public function getSlackId()
    {
        return $this->slackId;
    }

    public function setCreatedAtFromTimestamp($timestamp)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        $this->createdAt = $date;
    }

    /**
     * @param mixed $slackId
     */
    public function setSlackId($slackId)
    {
        $this->slackId = $slackId;
    }

    /**
     * @return Slack
     */
    public function getSlackTS()
    {
        return $this->slackTS;
    }

    /**
     * @param Slack $slackTS
     */
    public function setSlackTS($slackTS)
    {
        $this->slackTS = $slackTS;
    }

    /**
     * @return int
     */
    public function getReactionsCount()
    {
        return $this->reactionsCount;
    }

    /**
     * @param int $reactionsCount
     */
    public function setReactionsCount($reactionsCount)
    {
        $this->reactionsCount = $reactionsCount;
    }

    /**
     * @return boolean
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * @param boolean $sent
     */
    public function setSent($sent)
    {
        $this->sent = $sent;
    }

    /**
     * @return mixed
     */
    public function getLinkInfo()
    {
        return $this->linkInfo;
    }

    /**
     * @param mixed $linkInfo
     */
    public function setLinkInfo($linkInfo)
    {
        $this->linkInfo = $linkInfo;
    }


}
