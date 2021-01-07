<?php

declare(strict_types=1);

use Onliner\CommandBus\Builder;
use Onliner\CommandBus\Context;
use Onliner\CommandBus\Retry\Option\Attempt;
use Onliner\CommandBus\Retry\RetryExtension;
use Onliner\CommandBus\Retry\Policy;

require __DIR__ . '/../vendor/autoload.php';

class MaybeFail
{
}

$retry = new RetryExtension();
$retry->policy(MaybeFail::class, new Policy\SimplePolicy(3));

$dispatcher = (new Builder())
    ->handle(MaybeFail::class, function (MaybeFail $command, Context $context) {
        $attempt = $context->get(Attempt::class) ?? new Attempt();

        if ($attempt->value < 3) {
            echo 'Fail ' , $attempt->value , ' times', \PHP_EOL;

            throw new LogicException();
        }

        echo 'Executed!', \PHP_EOL;
    })
    ->use($retry)
    ->build();

$dispatcher->dispatch(new MaybeFail());
