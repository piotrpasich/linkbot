<?php

namespace XTeam\SlackMessengerBundle\Model;

use XTeam\SlackMessengerBundle\ValueObject\Name;
use XTeam\SlackMessengerBundle\ValueObject\StringId;

class Channel
{

    /**
     * @var StringId
     */
    protected $id;

    /**
     * @var Name
     */
    protected $name;

    public function __construct($id, $name)
    {
        $this->setId($id);
        $this->setName($name);
    }

    /**
     * @return StringId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $id
     */
    protected function setId($id)
    {
        $this->id = new StringId($id);
    }

    /**
     * @param String $name
     */
    protected function setName($name)
    {
        $this->name = new Name($name);
    }
}
