<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Service;

use App\Move\Command\Application\DTO\BoardStateDTO;
use App\Move\Command\Domain\Interfaces\MoveStrategyInterface;
use App\Move\Command\Model\Coordinates;
use App\Shared\Domain\Exception\EntityNotFoundException;
use App\Shared\Domain\Model\Uuid;
use App\Shared\Infrastructure\Repository\BoardRepository;

class MoveFinderService
{
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
                    $coordinates = $strategy->execute($boardStateDTO);

                    if($coordinates !== null) {
                        return $coordinates;
                    }
                }
            }

            return null;
        } catch (\Throwable $e) {
            $this->logger->critical('Could get find coordinates for board: ' . $boardUuid->value, ['error' => $e->getMessage()]);
            throw BadParameterException::fromData('Could get find coordinates for board: ' . $boardUuid->value, $e);
        }
    }
}
