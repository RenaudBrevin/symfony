<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TimestampSubscriber implements EventSubscriberInterface
{
    public function onCreateAt($event): void
    {
        $event->getEntity()->setCreatedAt(new \DateTime());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'createAt' => 'onCreateAt',
        ];
    }
}
