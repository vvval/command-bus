<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Remote\Serializer;

use Onliner\CommandBus\Exception\SerializeException;
use Onliner\CommandBus\Remote\Serializer;

final class NativeSerializer implements Serializer
{
    /**
     * {@inheritDoc}
     */
    public function serialize(string $type, object $message): string
    {
        $this->guard($type, $message);

        return serialize($message);
    }

    /**
     * {@inheritDoc}
     */
    public function deserialize(string $type, string $payload): object
    {
        $message = unserialize($payload);

        $this->guard($type, $message);

        return $message;
    }

    private function guard(string $type, object $message): void
    {
        if (get_class($message) !== $type) {
            throw new SerializeException();
        }
    }
}
