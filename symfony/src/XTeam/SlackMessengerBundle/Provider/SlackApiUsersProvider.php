<?php

namespace XTeam\SlackMessengerBundle\Provider;

use CL\Slack\Model\User;
use CL\Slack\Payload\UsersListPayload;
use CL\Slack\Transport\ApiClientInterface;
use XTeam\SlackMessengerBundle\Builder\UserBuilderInterface;
use XTeam\SlackMessengerBundle\Exception\SlackApiException;

class SlackApiUsersProvider
{
    /**
     * @var ApiClientInterface
     */
    protected $apiClient;

    /**
     * @var UserBuilderInterface
     */
    protected $userBuilder;

    public function __construct(ApiClientInterface $apiClient, UserBuilderInterface $userBuilder)
    {
        $this->apiClient = $apiClient;
        $this->userBuilder = $userBuilder;
    }

    public function getAll()
    {
        $payload = new UsersListPayload();

        $response = $this->apiClient->send($payload);

        if ($response->isOk()) {
            return array_map(function (User $user) {
                    return $this->userBuilder->getUser($user);
                }, $response->getUsers());
        } else {
            throw new SlackApiException($response->getError());
        }
    }
}
