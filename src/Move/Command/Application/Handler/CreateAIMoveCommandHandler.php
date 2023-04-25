<?php

declare(strict_types=1);

namespace App\Move\Command\Application\Handler;

use App\Move\Command\Domain\Command\CreateAIMoveCommand;
use App\Shared\Domain\Interfaces\Command\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Move\Command\Domain\Service\MoveService;
use App\Move\Command\Domain\Service\MoveFinderService;

#[AsMessageHandler]
class CreateAIMoveCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private MoveService $moveService,
        private MoveFinderService $moveFinderService,
    ) {
    }

    public function __invoke(CreateAIMoveCommand $command)
    {
        $coordinates = $this->moveFinderService->findCoordinates(
            $command->move->boardUuid
        );

        if ($coordinates !== null) {
            $this->moveService->move(
                $command->move->userUuid,
                $command->move->boardUuid,
                $coordinates
            );
        }
    }
}
