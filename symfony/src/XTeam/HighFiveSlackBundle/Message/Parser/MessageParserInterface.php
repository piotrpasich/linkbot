<?php

namespace XTeam\HighFiveSlackBundle\Message\Parser;

interface MessageParserInterface
{
    public function parse($text);

}