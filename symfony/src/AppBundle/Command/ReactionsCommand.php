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

class ReactionsCommand  extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('xteam:linkbot:parse:reactions')
            ->setDescription('Parses messeges from slack')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $links = $em->getRepository('AppBundle:Link')->findAll();

        foreach ($links as $link) {
            $reactions = $this->getContainer()->get('app.slack.provider')->getReactions($link);
            $link->setReactionsCount(count($reactions));

            $em->persist($link);
        }

        $em->flush();

        $output->writeln(sprintf("%d messages updated", count($links)));
    }
}
