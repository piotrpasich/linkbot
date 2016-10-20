<?php

namespace XTeam\HighFiveSlackBundle\Message\Parser;

use XTeam\HighFiveSlackBundle\DataProvider\SlackUserProvider;

class MentionsMessageParser implements MessageParserInterface
{
    /**
     * @var SlackUserProvider
     */
    private $userProvider;

    public function __construct(SlackUserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public function parse($text)
    {
        $mentions = [];
        preg_match_all("|\<\@(.*)\>|U", $text, $mentions, PREG_PATTERN_ORDER);

        if (empty($mentions[1])) {
            return [];
        }

        return array_map(function($userId) {
            return $this->userProvider->getUser($userId);
        }, $mentions[1]);
    }

}