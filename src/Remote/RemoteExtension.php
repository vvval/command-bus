<?php

declare(strict_types=1);

namespace Onliner\CommandBus\Remote;

use Onliner\CommandBus\Builder;
use Onliner\CommandBus\Context;
use Onliner\CommandBus\Extension;

final class RemoteExtension implements Extension
{
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
    public function __construct(Transport $transport = null, Serializer $serializer = null)
    {
        $this->transport  = $transport ?? new InMemory\InMemoryTransport();
        $this->serializer = $serializer ?? new Serializer\NativeSerializer();
    }

    /**
     * {@inheritDoc}
     */
    public function setup(Builder $builder, array $options): void
    {
        $gateway = new Gateway($this->transport, $this->serializer);

        $builder->middleware(new RemoteMiddleware($gateway));

        $builder->handle(Envelope::class, function (Envelope $envelope, Context $context) use ($gateway) {
            $gateway->receive($envelope, $context);
        });
    }
}
