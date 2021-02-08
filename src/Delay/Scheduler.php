<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Delay;

use Onliner\CommandBus\Context;

interface Scheduler
{
    /**
     * @param int     $delay
     * @param object  $message
     * @param Context $context
     *
     * @return void
     */
    public function delay(int $delay, object $message, Context $context): void;
}
