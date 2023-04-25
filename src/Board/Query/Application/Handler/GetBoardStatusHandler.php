<?php

declare(strict_types=1);

namespace App\Board\Query\Application\Handler;

use App\Shared\Domain\Interfaces\Query\QueryHandlerInterface;
use App\Board\Query\Domain\Query\GetBoardStatusQuery;
use App\Board\Query\Domain\Service\WinnerService;
use App\Board\Query\Application\DTO\BoardStatusDTO;
use App\Board\Query\Application\DTO\BoardStateDTO;

#[AsMessageHandler]
class GetBoardStatusHandler implements QueryHandlerInterface
{
    public function __construct(
        private WinnerService $winnerService
    ) {
    }

    public function __invoke(GetBoardStatusQuery $query): BoardStatusDTO
    {
        return $this->winnerService->getWinningBoard($query->boardStateDTO);
    }
}
