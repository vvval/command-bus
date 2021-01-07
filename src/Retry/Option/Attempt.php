<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Retry\Option;

use Onliner\CommandBus\Option;

final class Attempt implements Option
{
    /**
     * @var int
     */
    public $value;

    /**
     * @param int $value
     */
    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }
}
