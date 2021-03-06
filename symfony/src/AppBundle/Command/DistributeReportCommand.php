<?php

namespace AppBundle\Command;

use AppBundle\Entity\Link;
use AppBundle\Event\LinkSentEvent;
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

class DistributeReportCommand  extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('xteam:linkbot:distribute:report')
            ->setDescription('Parses messeges from slack')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $links = $em->getRepository('AppBundle:Link')->findUnsentByDate();

        foreach ($links as $link) {
            $this->getContainer()->get('event_dispatcher')->dispatch(LinkSentEvent::NAME, new LinkSentEvent($link));
            $link->setSent(true);
            $em->persist($link);
        }

        $em->flush();

        $output->writeln(sprintf("%d messages sent", count($links)));
    }
}
