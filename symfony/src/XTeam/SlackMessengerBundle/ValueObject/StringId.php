<?php

namespace XTeam\SlackMessengerBundle\ValueObject;

final class StringId
{

    private $stringId;

    public function __construct($stringId)
    {
        $this->guard($stringId);

        $this->stringId = $stringId;
    }

    public function __toString()
    {
        return $this->stringId;
    }

    public function isEqual(StringId $stringId)
    {
        return $this->stringId == $stringId->__toString();
    }

    private function guard($stringId)
    {
        if (empty($stringId) || !is_string($stringId)) {
            throw new \InvalidArgumentException("The Id should be a string");
        }
    }

}
