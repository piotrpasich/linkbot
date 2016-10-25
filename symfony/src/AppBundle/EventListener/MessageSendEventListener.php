<?php

namespace AppBundle\EventListener;

use AppBundle\Event\LinkSentEvent;
use AppBundle\Mapper\LinkMapper;
use AppBundle\Message\AuthorMessage;
use AppBundle\Message\WebsiteMessage;
use AppBundle\Repository\LinkRepository;
use AppBundle\Voter\LinkVoter;
use CL\Slack\Model\Attachment;
use CL\Slack\Model\AttachmentField;
use CL\Slack\Payload\ChatPostMessagePayload;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use XTeam\SlackMessengerBundle\Publisher\SlackApiMessagePublisher;

class MessageSendEventListener
{

    /**
     * @var SlackApiMessagePublisher
     */
    private $apiMessagePublisher;

    /**
     * @var array
     */
    private $configuration;

    public function __construct(SlackApiMessagePublisher $apiMessagePublisher, $configuration)
    {
        $this->apiMessagePublisher = $apiMessagePublisher;
        $this->configuration = $configuration;
    }

    public function sentMessage(LinkSentEvent $linkSentEvent)
    {
        try {
            $link = $linkSentEvent->getLink();

            $attachment = new Attachment();
            $attachment->setTitle($link->getLinkInfo()->title);
            $attachment->setText(urldecode($link->getLinkInfo()->description));
            $attachment->setAuthorName($link->getUser()->getName());
            $attachment->setTitleLink($link->getLink());
            $attachment->setFooter(sprintf('#%s', $link->getChannel()->getName()));
            $attachment->setColor("#36a64f");

            $field = new AttachmentField();
            $field->setTitle('Reactions');
            $field->setValue($link->getReactionsCount());

            $attachment->addField($field);

            if ('image' == $link->getType()) {
                $attachment->setImageUrl($link->getLink());
            } else if (isset($link->getLinkInfo()->images[0])) {
                $attachment->setImageUrl($link->getLinkInfo()->images[0]->url);
            }

            $payload = new ChatPostMessagePayload();
            $payload->addAttachment($attachment);
            $payload->setChannel($this->configuration['publish_channel']);
            $payload->setUsername($this->configuration['name']);
            $payload->setIconUrl($link->getUser()->getImage());
            $payload->setAsUser(false);

            $this->apiMessagePublisher->publishPayload($payload);

            $link->setSent(true);
        } catch (\Exception $e) {

        }
    }
}
