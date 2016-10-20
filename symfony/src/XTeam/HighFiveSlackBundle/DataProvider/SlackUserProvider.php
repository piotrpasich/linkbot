<?php

namespace XTeam\HighFiveSlackBundle\DataProvider;

use CL\Slack\Model\User;
use CL\Slack\Payload\UsersListPayload;
use CL\Slack\Transport\ApiClient;
use XTeam\HighFiveSlackBundle\Builder\UserEntityBuilder;
use XTeam\SlackMessengerBundle\Builder\UserBuilderInterface;

class SlackUserProvider
{

    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var UserEntityBuilder
     */
    private $userEntityBuilder;

    /**
     * @var UserBuilderInterface
     */
    private $userBuilder;

    private $users = [];

    public function __construct(
        ApiClient $apiClient,
        UserEntityBuilder $userEntityBuilder,
        UserBuilderInterface $userBuilder)
    {
        $this->apiClient = $apiClient;
        $this->userEntityBuilder = $userEntityBuilder;
        $this->userBuilder = $userBuilder;
    }

    public function getUser($userId)
    {
        $users = $this->getUsers();
        if ( ! isset($users[$userId])) {
            throw new \InvalidArgumentException('This user does not exist in Slack API');
        }

        return $this->userEntityBuilder->getUser($this->userBuilder->getUser($users[$userId]));
    }

    private function getUsers()
    {
        if (empty($this->users)) {
            $users = $this->apiClient->send(new UsersListPayload())->getUsers();
            $this->users = array_combine(
                array_map(function(User $user) {
                    return $user->getId();
                }, $users),
                $users
            );
        }

        return $this->users;
    }

}
