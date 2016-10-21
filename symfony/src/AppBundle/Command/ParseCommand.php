<?php

namespace AppBundle\Command;

use AppBundle\Event\MesssageReceivedEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use XTeam\SlackMessengerBundle\Event\MessageEvent;

class ParseCommand  extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('xteam:linkbot:parse:links')
            ->setDescription('Parses messeges from slack')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $lastHighFiveTimestamp = $em->getRepository('AppBundle:Link')->getLastTimeStamp();

        $messages = $this
            ->getContainer()
            ->get('x_team_slack_messenger.slack.provider')
            ->getMessagesFromAllChannels($lastHighFiveTimestamp, $this->getContainer()->getParameter('slack.channels'));

        foreach ($messages as $message) {
            $this->getContainer()->get('event_dispatcher')->dispatch(MesssageReceivedEvent::NAME, new MesssageReceivedEvent($message));
        }

        $em->flush();

        $output->writeln(sprintf("%d messages received", count($messages)));
    }
}
