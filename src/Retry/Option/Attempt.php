<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Retry\Option;

use Onliner\CommandBus\Option;
use Throwable;

final class Attempt implements Option
{
    /**
     * @var int
     */
    private $value;

    /**
     * @var Throwable
     */
    private $error;

    /**
     * @param int       $value
     * @param Throwable $error
     */
    public function __construct(Throwable $error, int $value = 0)
    {
        $this->value = $value;
        $this->error = $error;
    }

    /**
     * @return Throwable
     */
    public function error(): Throwable
    {
        return $this->error;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param int $max
     *
     * @return bool
     */
    public function reach(int $max): bool
    {
        return $this->value >= $max;
    }

    /**
     * @param Throwable $error
     *
     * @return self
     */
    public function next(Throwable $error): self
    {
        return new self($error, $this->value + 1);
    }
}
