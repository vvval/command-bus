<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Remote;

use Onliner\CommandBus\Context;

final class Gateway
{
    public const LOCAL = 'local';

    /**
     * @var Transport
     */
    private $transport;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Transport  $transport
     * @param Serializer $serializer
     */
    public function __construct(Transport $transport, Serializer $serializer)
    {
        $this->transport  = $transport;
        $this->serializer = $serializer;
    }

    /**
     * @param object       $message
     * @param array<mixed> $options
     *
     * @return void
     */
    public function send(object $message, array $options): void
    {
        $payload = $this->serializer->serialize(new Envelope(get_class($message), $message, $options));

        $this->transport->send();
    }

    /**
     * @param Envelope $envelope
     * @param Context  $context
     *
     * @return void
     */
    public function receive(Envelope $envelope, Context $context): void
    {
        $message = $this->serializer->deserialize($envelope->payload);

        $context->dispatch($message, $envelope->options + [
            self::LOCAL => true,
        ]);
    }
}
