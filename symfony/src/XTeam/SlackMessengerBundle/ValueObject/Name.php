<?php

namespace XTeam\SlackMessengerBundle\ValueObject;

final class Name
{

    private $name;

    public function __construct($name)
    {
        $this->guard($name);

        $this->name = $name;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function isEqual(Name $name)
    {
        return $this->name == $name->__toString();
    }

    private function guard($stringId)
    {
        if (empty($stringId) || !is_string($stringId)) {
            throw new \InvalidArgumentException("The Name should be a string");
        }
    }

}
