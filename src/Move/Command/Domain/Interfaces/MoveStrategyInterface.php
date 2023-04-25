<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Interfaces;

use App\Move\Command\Application\DTO\BoardStateDTO;
use App\Move\Command\Model\Coordinates;

interface MoveStrategyInterface
{
    public const TYPE_RECT = 'rectangular_board';

    public function supports(string $type): bool;

    public function execute(BoardStateDTO $boardStateDTO): ?Coordinates;
}
