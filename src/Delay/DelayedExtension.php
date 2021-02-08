<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Delay;

use Onliner\CommandBus\Builder;
use Onliner\CommandBus\Context;
use Onliner\CommandBus\Extension;
use Onliner\CommandBus\Middleware;

class DelayedExtension implements Extension, Middleware
{
    /**
     * @var Scheduler
     */
    private $scheduler;

    /**
     * @param Scheduler $scheduler
     */
    public function __construct(Scheduler $scheduler)
    {
        $this->scheduler = $scheduler;
    }

    /**
     * {@inheritDoc}
     */
    public function setup(Builder $builder): void
    {
        $builder->middleware($this);
    }

    /**
     * {@inheritDoc}
     */
    public function call(object $message, Context $context, callable $next): void
    {
        /** @var Option\Delay $delay */
        $delay = $context->get(Option\Delay::class);

        if ($delay !== null) {
            $this->scheduler->delay($delay->value(), $message, $context);

            return;
        }

        $next($message, $context);
    }
}
