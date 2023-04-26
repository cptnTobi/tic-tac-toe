<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Service\MoveStrategy;

use App\Board\Query\Domain\Interfaces\WinnerStrategyInterface;
use App\Move\Command\Application\DTO\BoardStateDTO;
use App\Move\Command\Domain\Interfaces\MoveStrategyInterface;
use App\Move\Command\Model\Coordinates;
use App\Shared\Domain\Exception\BadParameterException;

class MoveStrategyEmptyColumns implements MoveStrategyInterface
{
    public function supports(string $type): bool
    {
        return $type === WinnerStrategyInterface::TYPE_RECT;
    }

    public function execute(BoardStateDTO $boardStateDTO): array
    {
        $res = [];
        $boardSize = count($boardStateDTO->state[0]);

        for ($x = 0; $x < $boardSize; $x++) {
            $isFree = true;
            $tmpCoordinates = [];
            for ($y = 0; $y < $boardSize; $y++) {

                $isFree = $this->isFreeOrAI((string)$boardStateDTO->state[$x][$y]);
                if (!$isFree) {
                    break;
                }

                if (!$this->isTakenByAI((string)$boardStateDTO->state[$x][$y])) {
                    $tmpCoordinates[] = new Coordinates($x, $y);
                }
            }

            $res = array_merge($res, $tmpCoordinates);
        }

        return $res;
    }

    private function isFreeOrAI(string $userUuid): bool
    {
        return  (
            $userUuid === '0'
        ||  $userUuid === '1'
        );
    }

    private function isTakenByAI(string $userUuid): bool
    {
        return  $userUuid !== '0';
    }
}
