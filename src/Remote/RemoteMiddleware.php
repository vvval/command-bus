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
     * @var array
     */
    private $local;

    /**
     * @param Gateway       $gateway
     * @param array<string> $local
     */
    public function __construct(Gateway $gateway, array $local = [])
    {
        $this->gateway = $gateway;
        $this->local   = $local;
    }

    /**
     * {@inheritDoc}
     */
    public function call(object $message, Context $context, callable $next): void
    {
        if ($this->isLocal($message, $context)) {
            $next($message, $context);
        } else {
            $this->gateway->send($message, $context->all());
        }
    }

    private function isLocal(object $message, Context $context): bool
    {
        return in_array(get_class($message), $this->local) || $context->get(Gateway::LOCAL, false);
    }
}
