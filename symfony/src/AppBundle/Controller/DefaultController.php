<?php

namespace AppBundle\Controller;

use AppBundle\Event\LinkSentEvent;
use AppBundle\Event\MesssageReceivedEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Fusonic\OpenGraph\Consumer;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->get('doctrine.orm.default_entity_manager');
        $links = $em->getRepository('AppBundle:Link')->findReady();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'links' => $links
        ]);
    }
}
