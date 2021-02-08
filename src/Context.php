<?php

declare(strict_types=1);

namespace Onliner\CommandBus;

final class Context
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var array<mixed>
     */
    private $options;

    /**
     * @param Dispatcher            $dispatcher
     * @param array<string, Option> $options
     */
    public function __construct(Dispatcher $dispatcher, array $options)
    {
        $this->dispatcher = $dispatcher;
        $this->options    = $options;
    }

    /**
     * @param Dispatcher $dispatcher
     * @param array      $options
     *
     * @return self
     */
    public static function create(Dispatcher $dispatcher, array $options): self
    {
        return new self($dispatcher, array_combine(array_map(function (Option $option) {
            return get_class($option);
        }, $options), $options));
    }

    /**
     * @param object    $message
     * @param Option ...$options
     *
     * @return void
     */
    public function dispatch(object $message, Option ...$options): void
    {
        $this->dispatcher->dispatch($message, ...$options);
    }

    /**
     * @return array<mixed>
     */
    public function all(): array
    {
        return $this->options;
    }

    /**
     * @param string $option
     *
     * @return bool
     */
    public function has(string $option): bool
    {
        return array_key_exists($option, $this->options);
    }

    /**
     * @param string $option
     *
     * @return Option|null
     */
    public function get(string $option): ?Option
    {
        return $this->options[$option] ?? null;
    }

    /**
     * @param Option $option
     *
     * @return self
     */
    public function with(Option $option): self
    {
        return new self($this->dispatcher, array_replace($this->options, [
            get_class($option) => $option
        ]));
    }
}
