<?php

namespace Rezzza\CommandBus\Domain\Event;

use Rezzza\CommandBus\Domain\Consumer\Response;
use Symfony\Component\EventDispatcher\Event;

/**
 * OnConsumerResponseEvent
 *
 * @uses Event
 * @author Stephane PY <py.stephane1@gmail.com>
 */
class OnConsumerResponseEvent extends Event
{
    /**
     * @param Response $response response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
