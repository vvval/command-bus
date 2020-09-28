<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Remote;

use Onliner\CommandBus\Context;
use Onliner\CommandBus\Middleware;

final class RemoteMiddleware implements Middleware
{
    /**
     * @var Gateway
     */
    private $gateway;

    /**
     * @param Gateway $gateway
     */
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * {@inheritDoc}
     */
    public function call(object $message, Context $context, callable $next): void
    {
        if ($context->get(Gateway::LOCAL, false)) {
            $next($message, $context);
        } else {
            $this->gateway->send($message, $context->all());
        }
    }
}
