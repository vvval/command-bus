<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Delay\Option;

use Onliner\CommandBus\Option;

class Delay implements Option
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }
}
