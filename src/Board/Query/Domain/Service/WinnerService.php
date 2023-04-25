<?php

declare(strict_types=1);

namespace App\Board\Query\Domain\Service;

use App\Board\Query\Model\BoardState;
use App\Board\Query\Application\DTO\BoardStatusDTO;
use App\Board\Query\Domain\Interfaces\WinnerStrategyInterface;
use App\Board\Query\Application\DTO\BoardStateDTO;

class WinnerService
{
    public function __construct(
        private iterable $strategies
    ) {

    }

    public function getWinningBoard(BoardStateDTO $boardStateDTO): BoardStatusDTO
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports(WinnerStrategyInterface::TYPE_RECT)) {
                $winningBoardState = $strategy->execute($boardStateDTO);

                if ($winningBoardState->userUuid !== '0') {
                    return $winningBoardState;
                }
            }
        }

        return $winningBoardState;
    }
}
