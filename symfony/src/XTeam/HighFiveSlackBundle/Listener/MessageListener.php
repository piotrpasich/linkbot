<?php

namespace XTeam\HighFiveSlackBundle\Listener;

use Doctrine\ORM\EntityManager;
use XTeam\HighFiveSlackBundle\Entity\HighFiveRepository;
use XTeam\HighFiveSlackBundle\Mapper\HighFiveMapper;
use XTeam\SlackMessengerBundle\Event\MessageEvent;

class MessageListener
{

    /**
     * @var HighFiveMapper
     */
    protected $highFiveMapper;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var HighFiveRepository
     */
    protected $highFiveRepository;

    public function __construct(HighFiveMapper $highFiveMapper, EntityManager $em)
    {
        $this->highFiveMapper = $highFiveMapper;
        $this->em = $em;
        $this->highFiveRepository = $em->getRepository('XTeamHighFiveSlackBundle:highFive');
    }

    public function receiveMessage(MessageEvent $event)
    {
        $message = $event->getMessage();

        try {
            if ($this->highFiveRepository->getMatch($message->getCreatedAt(), $message->getUser()->getId())) {
                return false;
            }

            $highFive = $this->highFiveMapper->getHighFive($message);

            $this->em->persist($highFive);
        } catch (\Exception $e) {
            return false;
        }
    }
}
