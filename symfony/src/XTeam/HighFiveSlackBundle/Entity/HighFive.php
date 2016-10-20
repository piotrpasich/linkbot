<?php

namespace XTeam\HighFiveSlackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * HighFive
 */
class HighFive
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var Channel
     */
    private $channel;

    /**
     * @var User
     */
    private $publisher;

    /**
     * @var ArrayCollection
     */
    private $receivers;

    public function __construct()
    {
        $this->receivers = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setType(Type $type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setChannel($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getPublisher()
    {
        return $this->publisher;
    }

    public function addReceiver(User $receiver)
    {
        $this->receivers->set($receiver->getId(), $receiver);

        return $this;
    }

    public function getReceivers()
    {
        return $this->receivers;
    }
}
