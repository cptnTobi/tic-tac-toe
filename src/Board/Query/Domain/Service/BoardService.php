<?php

declare(strict_types=1);

namespace App\Board\Query\Domain\Service;

use App\Shared\Infrastructure\Logger\BaseLoggerInterface;
use App\Shared\Domain\Entity\Board;
use App\Shared\Domain\Model\Uuid;
use App\Shared\Infrastructure\Repository\BoardRepository;

class BoardService
{
    public function __construct(
        private BoardRepository $boardRepository,
        private BaseLoggerInterface $logger
    ) {
    }

    public function getBoard(Uuid $uuid): ?Board
    {
        try {
            return $this->boardRepository->getBoard($uuid);
        } catch (\Throwable $e) {
            $this->logger->critical('Could get board: ' . $uuid->value, ['error' => $e->getMessage()]);
            throw BadParameterException::fromData('Could get board: ' . $uuid->value, $e);
        }
    }
}
