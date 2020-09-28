<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Tests\Remote;

use Onliner\CommandBus\Context;
use Onliner\CommandBus\Remote\Envelope;
use Onliner\CommandBus\Remote\Gateway;
use Onliner\CommandBus\Remote\Serializer;
use Onliner\CommandBus\Remote\InMemory;
use Onliner\CommandBus\Tests\Command\Hello;
use PHPUnit\Framework\TestCase;

class GatewayTest extends TestCase
{
    public function testSend(): void
    {
        $transport  = new InMemory\InMemoryTransport();
        $serializer = new Serializer\NativeSerializer();

        $command = new Hello('onliner');
        $options = [
            'foo' => 'bar',
        ];

        $gateway = new Gateway($transport, $serializer);
        $gateway->send($command, $options);

        $queue = $transport->receive(Hello::class);

        self::assertCount(1, $queue);

        /** @var Envelope $envelope */
        $envelope = reset($queue);

        self::assertInstanceOf(Envelope::class, $envelope);
        self::assertSame(get_class($command), $envelope->type);
        self::assertSame($serializer->serialize($command), $envelope->payload);
        self::assertSame($options, $envelope->options);
    }
}
