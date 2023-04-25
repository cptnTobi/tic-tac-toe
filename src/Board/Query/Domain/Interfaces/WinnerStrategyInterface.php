<?php

declare(strict_types=1);

namespace App\Board\Query\Domain\Interfaces;

use App\Board\Query\Model\BoardState;
use App\Board\Query\Application\DTO\BoardStatusDTO;
use App\Board\Query\Application\DTO\BoardStateDTO;

interface WinnerStrategyInterface
{
    public const TYPE_RECT = 'rectangular_board';

    public function supports(string $type): bool;

    public function execute(BoardStateDTO $boardStateDTO): BoardStatusDTO;
}
