<?php
namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MiListener
{
    public function myEventListener(Event $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        
    }
}