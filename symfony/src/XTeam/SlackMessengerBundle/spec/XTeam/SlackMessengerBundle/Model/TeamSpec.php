<?php

namespace spec\XTeam\SlackMessengerBundle\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TeamSpec extends ObjectBehavior
{
    private $wrongDataSet = [
        [
            'teamId' => 1,
            'teamDomain' => [],
            'message' => "The Id should be a string",
        ],
        [
            'teamId' => 'C2147483705',
            'teamDomain' => [],
            'message' => "The Name should be a string",
        ],
        [
            'teamId' => 1,
            'teamDomain' => 'XTeam',
            'message' => "The Id should be a string",
        ],
    ];

    function it_is_initializable()
    {
        $this->beConstructedWith(
            $teamId = 'C2147483705',
            $teamDomain = 'XTeam'
        );
        $this->shouldHaveType('XTeam\SlackMessengerBundle\Model\Team');
        $this->getDomain()->__toString()->shouldReturn($teamDomain);
        $this->getId()->__toString()->shouldReturn($teamId);
    }

    function it_cannot_initialize_wrong_data()
    {
        foreach ($this->wrongDataSet as $dataSet) {
            $this->shouldThrow(new \InvalidArgumentException($dataSet['message']))
                 ->during('__construct',[
                     $dataSet['teamId'],
                     $dataSet['teamDomain']
                 ]);
        }
    }
}
