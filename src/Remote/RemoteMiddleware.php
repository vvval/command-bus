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
        $this->local   = array_flip($local);
    }

    /**
     * {@inheritDoc}
     */
    public function call(object $message, Context $context, callable $next): void
    {
        if ($this->isLocal($message, $context)) {
            $next($message, $context);
        } else {
            $this->gateway->send($message, $context);
        }
    }

    /**
     * @param object  $message
     * @param Context $context
     *
     * @return bool
     */
    private function isLocal(object $message, Context $context): bool
    {
        return isset($this->local[get_class($message)]) || $context->get(Gateway::LOCAL, false);
    }
}
