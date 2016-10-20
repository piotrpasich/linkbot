<?php

namespace spec\XTeam\SlackMessengerBundle\Publisher;

use CL\Slack\Payload\ChatPostMessagePayload;
use CL\Slack\Transport\ApiClient;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlackApiMessagePublisherSpec extends ObjectBehavior
{
    function let()
    {
        $apiClient = new ApiClient('xoxp-7485179684-7485175255-7573445123-bf6f8d');
        $this->beConstructedWith($apiClient);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('XTeam\SlackMessengerBundle\Publisher\SlackApiMessagePublisher');
    }

    function it_can_publish_a_message()
    {
        $this->publish(
            $channel = '#general',
            $message = 'test message'
        );
    }
}
