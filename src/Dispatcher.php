<?php

declare(strict_types=1);

namespace Onliner\CommandBus;

final class Dispatcher
{
    /**
     * @var Resolver
     */
    private $resolver;

    /**
     * @param Resolver $resolver
     */
    public function __construct(Resolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param object     $message
     * @param Option  ...$options
     *
     * @return void
     */
    public function dispatch(object $message, Option ...$options): void
    {
        $handler = $this->resolver->resolve($message);
        $handler($message, Context::create($this, $options));
    }
}
