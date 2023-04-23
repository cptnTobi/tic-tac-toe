<?php

declare(strict_types=1);

namespace App\Move\Command\Application\Handler;

use App\Move\Command\Domain\Command\CreateMoveCommand;
use App\Shared\Domain\Interfaces\Command\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateMoveCommandHandler implements CommandHandlerInterface
{
    public function __construct(

    ) {
    }

    public function __invoke(CreateMoveCommand $command)
    {

    }
}
