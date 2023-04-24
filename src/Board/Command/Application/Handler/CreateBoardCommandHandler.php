<?php

declare(strict_types=1);

namespace App\Board\Command\Application\Handler;

use App\Board\Command\Domain\Command\CreateBoardCommand;
use App\Shared\Domain\Interfaces\Command\CommandHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Board\Command\Domain\Service\BoardService;

#[AsMessageHandler]
class CreateBoardCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private BoardService $boardService
    ) {
    }

    public function __invoke(CreateBoardCommand $command)
    {
        $this->boardService->createBoard($command->uuid);
    }
}
