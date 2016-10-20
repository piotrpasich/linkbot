<?php

namespace spec\XTeam\SlackMessengerBundle\Builder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlackAPIMessageBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('XTeam\SlackMessengerBundle\Builder\SlackAPIMessageBuilder');
    }

    function it_can_build_message_from_slack_api()
    {
        $rawSlackApiData = [
            'token' => 'XXXXXXXXXXXXXXXXXX',
            'team_id' => 'T0001',
            'team_domain' => 'example',
            'channel_id' => 'C2147483705',
            'channel_name' => 'test',
            'timestamp' => '1355517523.000005',
            'user_id' => 'U2147483697',
            'user_name' => 'Steve',
            'text' => 'googlebot: What is the air-speed velocity of an unladen swallow?',
            'trigger_word' => 'googlebot:',
        ];

        $message = $this->getMessage($rawSlackApiData);

        $message->shouldHaveType('XTeam\SlackMessengerBundle\Model\Message');
        $message->getText()->shouldReturn($rawSlackApiData['text']);
        $message->getTriggerWord()->shouldReturn($rawSlackApiData['trigger_word']);

        $message->getTeam()->shouldHaveType('XTeam\SlackMessengerBundle\Model\Team');
        $message->getTeam()->getId()->__toString()->shouldReturn($rawSlackApiData['team_id']);
        $message->getTeam()->getDomain()->__toString()->shouldReturn($rawSlackApiData['team_domain']);

        $message->getChannel()->shouldHaveType('XTeam\SlackMessengerBundle\Model\Channel');
        $message->getChannel()->getId()->__toString()->shouldReturn($rawSlackApiData['channel_id']);
        $message->getChannel()->getName()->__toString()->shouldReturn($rawSlackApiData['channel_name']);

        $message->getUser()->shouldHaveType('XTeam\SlackMessengerBundle\Model\User');
        $message->getUser()->getId()->__toString()->shouldReturn($rawSlackApiData['user_id']);
        $message->getUser()->getName()->__toString()->shouldReturn($rawSlackApiData['user_name']);
    }
}
