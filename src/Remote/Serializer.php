<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Remote;

interface Serializer
{
    /**
     * @param string $type
     * @param object $message
     *
     * @return string
     */
    public function serialize(string $type, object $message): string;

    /**
     * @param string $type
     * @param string $payload
     *
     * @return object
     */
    public function deserialize(string $type, string $payload): object;
}
