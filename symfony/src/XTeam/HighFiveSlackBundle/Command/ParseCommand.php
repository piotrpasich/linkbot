<?php

namespace XTeam\HighFiveSlackBundle\Command;

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
            ->setName('xteam:slack:parse')
            ->setDescription('Parses messeges from slack')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $lastHighFiveTimestamp = $em->getRepository('XTeamHighFiveSlackBundle:HighFive')->getLastTimeStamp() + 1;

        $messages = $this->getContainer()
            ->get('x_team_slack_messenger.slack.provider')
            ->getMessagesFromAllChannels($lastHighFiveTimestamp);

        foreach ($messages as $message) {
            $output->writeln($message->getText());
            $this->getContainer()
                ->get('event_dispatcher')
                ->dispatch('xteam.five.message_received', new MessageEvent($message));
        }

        $em->flush();
        $output->writeln(sprintf("%d messages received", count($messages)));
    }
}
