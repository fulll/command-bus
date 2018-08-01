<?php

namespace Rezzza\CommandBus\Domain;

use Rezzza\CommandBus\Domain\EventDispatcherBus;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ContainerAwareEventDispatcherBus extends EventDispatcherBus
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
