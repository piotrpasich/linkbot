<?php

namespace AppBundle\EventListener;

use AppBundle\Event\MesssageReceivedEvent;
use AppBundle\Mapper\LinkMapper;
use AppBundle\Repository\LinkRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MessageReceivedEventListener
{

    /**
     * @var LinkRepository
     */
    private $linkRepository;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var LinkMapper
     */
    private $linkMapper;

    public function __construct(LinkRepository $linkRepository, EntityManager $em, LinkMapper $linkMapper)
    {
        $this->linkRepository = $linkRepository;
        $this->em = $em;
        $this->linkMapper = $linkMapper;
    }

    public function receiveMessage(MesssageReceivedEvent $messsageReceivedEvent)
    {
        $message = $messsageReceivedEvent->getMessage();

        try {
            if ($this->linkRepository->getMatch($message)) {
                return false;
            }

            $link = $this->linkMapper->getLink($message);

            $this->em->persist($link);
        } catch (\Exception $e) {
            throw $e;
            return false;
        }
    }
}
