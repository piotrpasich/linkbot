<?php

namespace XTeam\SlackMessengerBundle\Tests\Controller;

use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Stopwatch\Stopwatch;
use XTeam\SlackMessengerBundle\Builder\SlackAPIMessageBuilder;
use XTeam\SlackMessengerBundle\Controller\MessageController;

class MessageControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testMessageAction()
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

        $dispatcher = new TraceableEventDispatcher(new EventDispatcher(), new Stopwatch());
        $controller = new MessageController($dispatcher, new SlackAPIMessageBuilder());

        $response = $controller->sendAction(new Request([], $rawSlackApiData));

        $this->assertEquals(200, $response->getStatusCode());
    }
}
