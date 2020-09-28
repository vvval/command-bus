<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Tests\Remote;

use Onliner\CommandBus\Remote\Envelope;
use PHPUnit\Framework\TestCase;

class EnvelopeTest extends TestCase
{
    public function testSerializeUnserialize(): void
    {
        $type  = 'type';
        $payload = 'payload';
        $headers = [
            'foo' => 'bar'
        ];

        $envelope = new Envelope($type, $payload, $headers);

        self::assertSame($type, $envelope->type);
        self::assertSame($payload, $envelope->payload);
        self::assertSame($headers, $envelope->options);
    }
}
