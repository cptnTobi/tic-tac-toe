<?php

declare(strict_types=1);

namespace App\Board\Query\Application\Handler;

use App\Board\Query\Application\DTO\BoardStateDTO;
use App\Board\Query\Domain\Query\GetBoardStateQuery;
use App\Board\Query\Domain\Service\BoardService;
use App\Shared\Domain\Interfaces\Query\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetBoardStateHandler implements QueryHandlerInterface
{
    public function __construct(
        private BoardService $boardService
    ) {
    }

    public function __invoke(GetBoardStateQuery $query): BoardStateDTO
    {
        $board =  $this->boardService->getBoard($query->uuid);

        return new BoardStateDTO($board);
    }
}
