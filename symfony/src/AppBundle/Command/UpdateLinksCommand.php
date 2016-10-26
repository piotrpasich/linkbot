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
use AppBundle\LinkParser\Consumer;
use AppBundle\Entity\Link;

class UpdateLinksCommand  extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('xteam:linkbot:update:links')
            ->setDescription('Downloads information from websites')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $links = $em->getRepository('AppBundle:Link')->findBy(['status' => [Link::STATUS_BROKEN, Link::STATUS_NEW]]);

        foreach ($links as $id => $link) {
            try {
                $consumer = new Consumer($this->getContainer()->get('x_team_slack_messenger.slack.provider'));

                $output->writeln(sprintf("[%d|%d] %s", $id, count($links), $link->getLink()));

                $object = $consumer->loadUrl($link->getLink());
                if ('image' == $object->type) {
                    $link->setLink($object->url);
                }
                $link->setType($object->type);
                $link->setLinkInfo($object);
                $link->setStatus($link::STATUS_READY);
            } catch (\Exception $e) {
                $output->writeln($e->getMessage());
                $link->setStatus($link::STATUS_BROKEN);
            }

            $em->persist($link);
        }

        $em->flush();

        $output->writeln('Done');
    }
}
