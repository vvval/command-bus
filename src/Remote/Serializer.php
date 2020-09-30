<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Remote;

interface Serializer
{
    /**
     * @param object $command
     *
     * @return string
     */
    public function serialize(object $command): string;

    /**
     * @param string $payload
     *
     * @return object
     */
    public function deserialize(string $payload): object;
}
