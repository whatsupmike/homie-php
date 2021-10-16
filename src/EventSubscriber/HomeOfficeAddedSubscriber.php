<?php

namespace App\EventSubscriber;

use App\Event\HomeOfficeAddedEvent;
use App\Service\ResponseFactory;
use App\Service\SlackClient\SlackClient;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HomeOfficeAddedSubscriber implements EventSubscriberInterface
{
    public function __construct(private SlackClient $slackClient, private ResponseFactory $responseFactory)
    {
    }

    public function onHomeOfficeAdded(HomeOfficeAddedEvent $event): void
    {
        $homeOffice = $event->getHomeOffice();
        $message = $this->responseFactory->buildSuccessMessage();
        $this->slackClient->chatPostMessage($homeOffice->getSlackUser()->getUserId(), $message);
    }

    #[ArrayShape(['homeOffice.added' => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            'homeOffice.added' => 'onHomeOfficeAdded',
        ];
    }
}
