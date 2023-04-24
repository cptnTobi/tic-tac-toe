<?php

declare(strict_types=1);

namespace App\Board\Command\Domain\Service;

use App\Shared\Infrastructure\Logger\BaseLoggerInterface;
use App\Shared\Domain\Entity\Board;
use App\Shared\Domain\Model\Uuid;
use App\Shared\Infrastructure\Repository\BoardRepository;

class BoardService
{
    private const BOARD_DEFAULT = [
        [0, 0, 0],
        [0, 0, 0],
        [0, 0, 0]
    ];

    public function __construct(
        private BoardRepository $boardRepository,
        private BaseLoggerInterface $logger
    ) {
    }

    public function createBoard(Uuid $uuid): void
    {
        $board = $this->boardRepository->find($uuid->value);
        if ($board) {
            $this->boardRepository->remove($board);
        }

        $board = new Board();

        $board->setId($uuid->value);
        $board->setState(json_encode(self::BOARD_DEFAULT));

        $this->boardRepository->save($board);
    }
}
