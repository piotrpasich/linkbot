<?php

namespace XTeam\HighFiveSlackBundle\Command;

use CL\Slack\Payload\UsersListPayload;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use XTeam\SlackMessengerBundle\Event\MessageEvent;

class ParseUsersCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('xteam:slack:parse:users')
            ->setDescription('Parses users from slack')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $userRepository = $em->getRepository('XTeamHighFiveSlackBundle:User');
        $users = $this->getContainer()->get('x_team_slack_messenger.slack.users.provider')->getAll();
        foreach ($users as $user) {
            $userMatch = $userRepository->getOneById($user->getId());
            if (null != $userMatch) {
                $userMatch->setName($user->getName());
                $userMatch->setImage($user->getImage());
                $em->persist($userMatch);
            }
        }

        $em->flush();
    }
}
