<?php

declare(strict_types=1);

namespace App\Move\Command\Application\Handler;

use App\Move\Command\Domain\Command\CreateMoveCommand;
use App\Shared\Domain\Interfaces\Command\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Move\Command\Domain\Service\MoveService;

#[AsMessageHandler]
class CreateMoveCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private MoveService $moveService
    ) {
    }

    public function __invoke(CreateMoveCommand $command)
    {
        $this->moveService->move(
            $command->move->userUuid,
            $command->move->boardUuid,
            $command->move->coordinates
        );
    }
}
