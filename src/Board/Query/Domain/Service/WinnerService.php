<?php

declare(strict_types=1);

namespace App\Board\Query\Domain\Service;

use App\Board\Query\Application\DTO\BoardStateDTO;
use App\Board\Query\Application\DTO\BoardStatusDTO;
use App\Board\Query\Domain\Interfaces\WinnerStrategyInterface;
use App\Shared\Domain\Exception\BadParameterException;
use App\Shared\Infrastructure\Logger\BaseLoggerInterface;
use Throwable;

class WinnerService
{
    public function __construct(
        private iterable $strategies,
        private BaseLoggerInterface $logger
    ) {

    }

    public function getWinningBoard(BoardStateDTO $boardStateDTO): BoardStatusDTO
    {
        try {
            foreach ($this->strategies as $strategy) {
                if ($strategy->supports(WinnerStrategyInterface::TYPE_RECT)) {
                    $winningBoardState = $strategy->execute($boardStateDTO);

                    if ($winningBoardState->userUuid !== '0') {
                        return $winningBoardState;
                    }
                }
            }

            return $winningBoardState;
        } catch (Throwable $e) {
            $this->logger->critical('Could not get winning board.', ['error' => $e->getMessage()]);
            throw BadParameterException::fromData('Could not get winning board.', $e);
        }
    }
}
