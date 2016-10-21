<?php

namespace AppBundle\EventListener;

use AppBundle\Event\MesssageReceivedEvent;
use AppBundle\Mapper\LinkMapper;
use AppBundle\Repository\LinkRepository;
use AppBundle\Voter\LinkVoter;
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
     * @var LinkMapper
     */
    private $linkMapper;

    /**
     * @var LinkVoter
     */
    private $linkVoter;

    public function __construct(LinkRepository $linkRepository, LinkMapper $linkMapper, LinkVoter $linkVoter)
    {
        $this->linkRepository = $linkRepository;
        $this->linkMapper = $linkMapper;
        $this->linkVoter = $linkVoter;
    }

    public function receiveMessage(MesssageReceivedEvent $messsageReceivedEvent)
    {
        $message = $messsageReceivedEvent->getMessage();

        try {
            if ($this->linkRepository->getMatch($message)) {
                return false;
            }

            $link = $this->linkMapper->getLink($message);

            if ($this->linkVoter->supports($link)) {
                $this->linkRepository->persist($link);
            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
