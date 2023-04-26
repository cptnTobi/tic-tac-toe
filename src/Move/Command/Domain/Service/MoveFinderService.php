<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Service;

use App\Move\Command\Application\DTO\BoardStateDTO;
use App\Move\Command\Domain\Interfaces\MoveStrategyInterface;
use App\Move\Command\Model\Coordinates;
use App\Shared\Domain\Exception\BadParameterException;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Domain\Model\Uuid;
use App\Shared\Infrastructure\Repository\BoardRepository;

class MoveFinderService
{
    private array $coordinatesRanking = [];

    public function __construct(
        private iterable $strategies,
        private BoardRepository $boardRepository
    ) {

    }

    public function findCoordinates(Uuid $boardUuid): ?Coordinates
    {
        try {
            $board = $this->boardRepository->find($boardUuid->value);
            if (!$board) {
                throw new EntityNotFoundException('Board not found: ' . $boardUuid->value);
            }

            $boardStateDTO = new BoardStateDTO(json_decode($board->getState()));

            foreach ($this->strategies as $strategy) {
                if ($strategy->supports(MoveStrategyInterface::TYPE_RECT)) {
                    $coordinatesList = $strategy->execute($boardStateDTO);

                    $this->addToRanking($coordinatesList);
                }
            }
            return $this->getHighestRankingCoordinates();
        } catch (\Throwable $e) {

            throw BadParameterException::fromData('Could not find coordinates for board: ' . $boardUuid->value, $e);
        }
    }

    private function addToRanking(array $coordinatesList): void
    {
        foreach ($coordinatesList as $coordinates) {
            $newCoordinateKey = (string)$coordinates;

            if (!array_key_exists($newCoordinateKey, $this->coordinatesRanking)) {
                $this->coordinatesRanking[$newCoordinateKey] = [
                    'coordinates' => $coordinates,
                    'ranking' => 1
                    ] ;
            } else {
                $this->coordinatesRanking[$newCoordinateKey] = [
                     'coordinates' => $coordinates,
                     'ranking' => $this->coordinatesRanking[$newCoordinateKey]['ranking'] + 1
                     ] ;
            }
        }

    }

    private function getHighestRankingCoordinates(): ?Coordinates
    {
        usort($this->coordinatesRanking, function ($a, $b) {
            return $a['ranking'] <= $b['ranking'];
        });

        return reset($this->coordinatesRanking)['coordinates'] ?? null;
    }
}
