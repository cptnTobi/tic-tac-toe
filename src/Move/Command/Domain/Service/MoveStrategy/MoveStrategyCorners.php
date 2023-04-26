<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Service\MoveStrategy;

use App\Board\Query\Domain\Interfaces\WinnerStrategyInterface;
use App\Move\Command\Application\DTO\BoardStateDTO;
use App\Move\Command\Domain\Interfaces\MoveStrategyInterface;
use App\Move\Command\Model\Coordinates;
use App\Shared\Domain\Exception\BadParameterException;

class MoveStrategyCorners implements MoveStrategyInterface
{
    public function supports(string $type): bool
    {
        return $type === WinnerStrategyInterface::TYPE_RECT;
    }

    public function execute(BoardStateDTO $boardStateDTO): array
    {
        $res = [];
        $boardSize = count($boardStateDTO->state[0]);
        
        $cornerCoordinates = [
            new Coordinates(0, 0),
            new Coordinates(0, $boardSize-1),
            new Coordinates($boardSize-1, 0),
            new Coordinates($boardSize-1, $boardSize-1)
        ];

        foreach ($cornerCoordinates as $cornerCoordinate) {

            if ($boardStateDTO->state[$cornerCoordinate->x->value][$cornerCoordinate->x->value] === 0) {
                $res[] =$cornerCoordinate;
            }
        }

        return $res;
    }
}
