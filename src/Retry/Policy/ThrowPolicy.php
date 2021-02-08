<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Retry\Policy;

use Onliner\CommandBus\Context;
use Onliner\CommandBus\Retry\Option;
use Onliner\CommandBus\Retry\Policy;
use Throwable;

final class ThrowPolicy implements Policy
{
    /**
     * @var string[]
     */
    private $except;

    /**
     * @param string ...$except
     */
    public function __construct(string ...$except)
    {
        $this->except = $except;
    }

    /**
     * {@inheritDoc}
     */
    public function retry(object $message, Context $context, Throwable $error): void
    {
        foreach ($this->except as $class) {
            if (is_a($error, $class)) {
                $context->dispatch($message, new Option\Attempt($error));

                return;
            }
        }

        throw $error;
    }
}
