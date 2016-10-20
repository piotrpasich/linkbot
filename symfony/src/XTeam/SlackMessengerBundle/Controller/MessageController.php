<?php

namespace XTeam\SlackMessengerBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use XTeam\SlackMessengerBundle\Builder\MessageBuilderInterface;
use XTeam\SlackMessengerBundle\Event\MessageEvent;

class MessageController extends Controller
{
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var MessageBuilder
     */
    protected $messageBuilder;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function __construct(TraceableEventDispatcher $eventDispatcher,
                                MessageBuilderInterface $messageBuilder,
                                EntityManager $entityManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->messageBuilder = $messageBuilder;
        $this->entityManager = $entityManager;
    }

    public function sendAction(Request $request)
    {
        $message = $this->messageBuilder->getMessage($request->request->all());
        $this->eventDispatcher->dispatch('slack.message_received', new MessageEvent($message));

        $this->entityManager->flush();

        return new JsonResponse([]);
    }
}
