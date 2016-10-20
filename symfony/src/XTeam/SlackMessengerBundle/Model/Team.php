<?php

namespace XTeam\SlackMessengerBundle\Model;

use XTeam\SlackMessengerBundle\ValueObject\Name;
use XTeam\SlackMessengerBundle\ValueObject\StringId;

class Team
{

    /**
     * ex. C2147483705
     * @var Integer
     */
    protected $id;

    /**
     * @var String
     */
    protected $domain;

    public function __construct($id, $domain)
    {
        $this->setId($id);
        $this->setDomain($domain);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getDomain()
    {
        return $this->domain;
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
    protected function setDomain($domain)
    {
        $this->domain = new Name($domain);
    }

}
