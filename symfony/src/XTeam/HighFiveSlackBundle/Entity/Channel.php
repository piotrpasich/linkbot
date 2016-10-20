<?php

namespace XTeam\HighFiveSlackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Channel
 */
class Channel
{
    /**
     * @var string
     */
    private $id;

    private $slackId;
    /**
     * @var string
     */
    private $name;


    private $highFives;

    public function __construct()
    {
        $this->highFives = new ArrayCollection();
    }


    public function setSlackId($slackId)
    {
        $this->slackId = $slackId;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getSlackId()
    {
        return $this->channelId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Channel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ArrayCollection
     */
    public function getHighFives()
    {
        return $this->highFives;
    }

    /**
     * @param ArrayCollection $highFives
     */
    public function setHighFives($highFives)
    {
        $this->highFives = $highFives;
    }
}
