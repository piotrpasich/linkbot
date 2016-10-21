<?php

namespace AppBundle\Controller;

use AppBundle\Event\LinkSentEvent;
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
        $links = $em->getRepository('AppBundle:Link')->findUnsent();

        foreach ($links as $link) {
            $this->get('event_dispatcher')->dispatch(LinkSentEvent::NAME, new LinkSentEvent($link));
            $em->persist($link);
        }

        $em->flush();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
