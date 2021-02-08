<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Delay\Scheduler;

use Onliner\CommandBus\Context;
use Onliner\CommandBus\Delay\Scheduler;

class BlockingScheduler implements Scheduler
{
    /**
     * {@inheritDoc}
     */
    public function delay(int $delay, object $message, Context $context): void
    {
        usleep($delay);

        $context->dispatch($message);
    }
}
