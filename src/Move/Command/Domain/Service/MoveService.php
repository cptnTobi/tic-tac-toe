<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Service;

use App\Move\Command\Model\Coordinates;
use App\Shared\Domain\Exception\BadParameterException;
use App\Shared\Domain\Model\Uuid;
use App\Shared\Infrastructure\Logger\BaseLoggerInterface;
use App\Shared\Infrastructure\Repository\BoardRepository;
use Doctrine\ORM\EntityNotFoundException;

class MoveService
{
    public function __construct(
        private BoardRepository $boardRepository,
        private BaseLoggerInterface $logger
    ) {
    }

    public function move(Uuid $userUuid, Uuid $boardUuid, Coordinates $coordinates): void
    {
        $board = $this->boardRepository->find($boardUuid->value);
        if (!$board) {
            throw new EntityNotFoundException('Board not found: ' . $boardUuid->value);
        }

        $boardState = json_decode($board->getState());
        $this->guardCoordinates($boardState, $coordinates);

        $boardState = $this->setStateCoordinates($boardState, $coordinates, $userUuid);

        $board->setState(json_encode($boardState));
        $this->boardRepository->save($board);
    }



    private function guardCoordinates(array $boardState, Coordinates $coordinates): void
    {
        if (
            !isset($boardState[$coordinates->x->value][$coordinates->y->value])
            || $boardState[$coordinates->x->value][$coordinates->y->value] !== 0
        ) {
            throw new BadParameterException('Coordinates are already used: ' . $coordinates->x->value . ' - ' . $coordinates->y->value);
        }
    }

      private function setStateCoordinates(array $boardState, Coordinates $coordinates, Uuid $userUuid): array
      {
          $boardState[$coordinates->x->value][$coordinates->y->value] = $userUuid->value;
          return  $boardState;
      }
}
