<?php

namespace AppBundle\Controller;

use AppBundle\Event\MesssageReceivedEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $lastHighFiveTimestamp = $em->getRepository('XTeamHighFiveSlackBundle:HighFive')->getLastTimeStamp() + 1;

        $messages = $this
            ->get('x_team_slack_messenger.slack.provider')
            ->getMessagesFromAllChannels($lastHighFiveTimestamp, ['test2']); //@papi @todo

        foreach ($messages as $message) {
            $this->get('event_dispatcher')->dispatch(MesssageReceivedEvent::NAME, new MesssageReceivedEvent($message));
        }

        $em->flush();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
