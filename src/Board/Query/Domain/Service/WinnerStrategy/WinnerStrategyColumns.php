<?php

declare(strict_types=1);

namespace App\Board\Query\Domain\Service\WinnerStrategy;

use App\Board\Query\Model\BoardState;
use App\Board\Query\Application\DTO\BoardStatusDTO;
use App\Board\Query\Domain\Interfaces\WinnerStrategyInterface;
use App\Board\Query\Application\DTO\BoardStateDTO;

class WinnerStrategyColumns implements WinnerStrategyInterface
{
    public function supports(string $type): bool
    {
        return $type === WinnerStrategyInterface::TYPE_RECT;
    }

    public function execute(BoardStateDTO $boardStateDTO): BoardStatusDTO
    {
        $size = count($boardStateDTO->state);

        $userUuids = ['1','2'];
        foreach ($userUuids as $userUuid) {
            for ($x = 0; $x < $size; $x++) {
                for ($y = 0; $y < $size; $y++) {

                    if ($boardStateDTO->state[$x][$y] === $userUuid) {
                        if ($y === $size -1) {
                            return new BoardStatusDTO($userUuid, $boardStateDTO->state); // TODO: Return $boardStateDTO with marked winning strike, to display
                        }
                        continue;
                    } else {
                        break;
                    }
                }
            }
        }

        return new BoardStatusDTO('0', $boardStateDTO->state);
    }
}
