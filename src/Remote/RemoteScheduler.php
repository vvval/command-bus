<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Remote;

use Onliner\CommandBus\Context;
use Onliner\CommandBus\Delay\Scheduler;

final class RemoteScheduler implements Scheduler
{
    /**
     * @var DelayedTransport
     */
    private $transport;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param DelayedTransport $transport
     * @param Serializer       $serializer
     */
    public function __construct(DelayedTransport $transport, Serializer $serializer)
    {
        $this->transport  = $transport;
        $this->serializer = $serializer;
    }

    /**
     * {@inheritDoc}
     */
    public function delay(int $delay, object $message, Context $context): void
    {
        $envelope = $this->serializer->serialize($message);
    }
}
