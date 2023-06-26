<?php

namespace Rezzza\CommandBus\Domain;

use Rezzza\CommandBus\Domain\Consumer\Response;
use Rezzza\CommandBus\Domain\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class EventDispatcherBus implements CommandBusInterface
{
    private $eventDispatcher;

    private $delegateCommandBus;

    public function __construct(EventDispatcherInterface $eventDispatcher, CommandBusInterface $delegateCommandBus)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->delegateCommandBus = $delegateCommandBus;
    }

    public function getHandleType()
    {
        return $this->delegateCommandBus->getHandleType();
    }

    public function handle(CommandInterface $command, $priority = null)
    {
        try {
            $this->eventDispatcher->dispatch(
                new Event\PreHandleCommandEvent($this->getHandleType(), $command),
                Event\Events::PRE_HANDLE_COMMAND
            );

            $result = $this->delegateCommandBus->handle($command, $priority);

            $this->eventDispatcher->dispatch(
                new Event\OnDirectResponseEvent($this->getHandleType(), new Response($command, Response::SUCCESS)),
                Event\Events::ON_DIRECT_RESPONSE
            );

            return $result;
        } catch (\Exception $e) {
            $this->eventDispatcher->dispatch(
                new Event\OnDirectResponseEvent($this->getHandleType(), new Response($command, Response::FAILED, $e)),
                Event\Events::ON_DIRECT_RESPONSE
            );

            throw $e;
        }
    }
}
