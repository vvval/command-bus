<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Retry\Policy;

use Onliner\CommandBus\Context;
use Onliner\CommandBus\Retry\Policy;
use Onliner\CommandBus\Retry\Option;
use Throwable;

final class SimplePolicy implements Policy
{
    /**
     * @var int
     */
    private $retries;

    /**
     * @var int
     */
    private $delay;

    /**
     * @param int $retries
     * @param int $delay
     */
    public function __construct(int $retries, int $delay = 0)
    {
        $this->retries = $retries;
        $this->delay   = $delay;
    }

    /**
     * {@inheritDoc}
     */
    public function retry(object $message, Context $context, Throwable $error): void
    {
        /** @var Option\Attempt $attempt */
        $attempt = $context->get(Option\Attempt::class) ?? new Option\Attempt($error);

        if ($attempt->reach($this->retries)) {
            throw $error;
        }

        if ($this->delay > 0) {
            usleep($this->delay);
        }


        $context->dispatch($message, $attempt->next($error));
    }
}
