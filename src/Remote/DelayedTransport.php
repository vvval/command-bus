<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Remote;

interface DelayedTransport
{
    /**
     * @param int      $delay
     * @param Envelope $envelope
     */
    public function delay(int $delay, Envelope $envelope): void;
}
