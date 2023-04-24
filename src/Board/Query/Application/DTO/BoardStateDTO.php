<?php

declare(strict_types=1);

namespace App\Board\Query\Application\DTO;

use App\Shared\Domain\Entity\Board;

class BoardStateDTO
{
    public string $uuid;
    public array $state;

    public function __construct(
        private Board $board
    ) {
        $this->uuid = $board->getId();
        $this->state = json_decode($board->getState());
    }
}
