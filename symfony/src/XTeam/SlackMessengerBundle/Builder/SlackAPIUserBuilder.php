<?php

namespace XTeam\SlackMessengerBundle\Builder;

use CL\Slack\Model\User as SlackApiUser;
use XTeam\SlackMessengerBundle\Model\User;

class SlackAPIUserBuilder implements UserBuilderInterface
{
    public function getUser($user)
    {
        if ( ! $user instanceof SlackApiUser) {
            throw new \InvalidArgumentException("The User should by type of CL\Slack\Model\User");
        }

        return new User($user->getId(), $user->getName(), $user->getProfile()->getImage48());
    }
}
