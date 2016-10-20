<?php

namespace XTeam\SlackMessengerBundle\Model;

use XTeam\SlackMessengerBundle\ValueObject\Name;
use XTeam\SlackMessengerBundle\ValueObject\StringId;

class User
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

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    protected function setId($id)
    {
        $this->id = new StringId($id);
    }

    protected function setName($name)
    {
        $this->name = new Name($name);
    }
}
