<?php

namespace XTeam\HighFiveSlackBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ArrayCollection
     */
    private $highFivesReceived;

    /**
     * @var ArrayCollection
     */
    private $highFivesPublished;

    private $image;

    public function __construct()
    {
        $this->highFivesReceived = new ArrayCollection();
        $this->highFivesPublished = new ArrayCollection();
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;

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

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
    public function getHighFivesReceived()
    {
        return $this->highFivesReceived;
    }

    /**
     * @return ArrayCollection
     */
    public function getHighFivesPublished()
    {
        return $this->highFivesPublished;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}
