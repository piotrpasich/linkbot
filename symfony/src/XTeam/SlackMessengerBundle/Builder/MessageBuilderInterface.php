<?php

namespace XTeam\SlackMessengerBundle\Builder;

interface MessageBuilderInterface
{
    /**
     * Returns Message
     *
     * @param array $rawPayloadData
     * @return Message
     */
    public function getMessage($rawPayloadData);

}
