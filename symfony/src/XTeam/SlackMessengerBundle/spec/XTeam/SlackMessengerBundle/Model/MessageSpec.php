<?php

namespace spec\XTeam\SlackMessengerBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use XTeam\SlackMessengerBundle\Model\Channel;
use XTeam\SlackMessengerBundle\Model\Team;
use XTeam\SlackMessengerBundle\Model\User;

class MessageSpec extends ObjectBehavior
{
    private $wrongDataSet = [
        [
            'text' => [],
            'triggerWord' => 'word',
            'message' => "The text should be a string",
        ],
        [
            'text' => 'Some test string',
            'triggerWord' => [],
            'message' => "The trigger word should be a string",
        ],
        [
            'text' => [],
            'triggerWord' => [],
            'message' => "The text should be a string",
        ],
    ];

    function it_is_initializable(Team $team, Channel $channel, User $user)
    {
        $this->beConstructedWith(
            $user,
            $team,
            $channel,
            $text = 'Some example test to check if this works',
            $triggerWord = 'works'
        );

        $this->shouldHaveType('XTeam\SlackMessengerBundle\Model\Message');

        $this->getTeam()->shouldHaveType('XTeam\SlackMessengerBundle\Model\Team');
        $this->getChannel()->shouldHaveType('XTeam\SlackMessengerBundle\Model\Channel');
        $this->getUser()->shouldHaveType('XTeam\SlackMessengerBundle\Model\User');

        $this->getText()->shouldReturn($text);
        $this->getTriggerWord()->shouldReturn($triggerWord);
    }

    function it_cannot_create_object_with_wrong_data(Team $team, Channel $channel, User $user)
    {
        foreach ($this->wrongDataSet as $dataSet) {
            $this->shouldThrow(new \InvalidArgumentException($dataSet['message']))
                 ->during('__construct',[
                     $user,
                     $team,
                     $channel,
                     $dataSet['text'],
                     $dataSet['triggerWord']
                 ]);
        }
    }
}
