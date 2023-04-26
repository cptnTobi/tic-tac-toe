<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Service\MoveStrategy;

use App\Board\Query\Domain\Interfaces\WinnerStrategyInterface;
use App\Move\Command\Application\DTO\BoardStateDTO;
use App\Move\Command\Domain\Interfaces\MoveStrategyInterface;
use App\Move\Command\Model\Coordinates;
use App\Shared\Domain\Exception\BadParameterException;

class MoveStrategyEmptyFields implements MoveStrategyInterface
{
    public function supports(string $type): bool
    {
        return $type === WinnerStrategyInterface::TYPE_RECT;
    }

    public function execute(BoardStateDTO $boardStateDTO): array
    {
        $res = [];
        $boardSize = count($boardStateDTO->state[0]);

        for ($y = 0; $y < $boardSize; $y++) {
            for ($x = 0; $x < $boardSize; $x++) {
                if ($boardStateDTO->state[$x][$y] === 0) {
                    $res[] = new Coordinates($x, $y);
                }
            }
        }

        return $res;
    }
}
