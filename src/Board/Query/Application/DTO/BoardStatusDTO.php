<?php

declare(strict_types=1);

namespace App\Board\Query\Application\DTO;

class BoardStatusDTO
{
    public function __construct(
        public string $userUuid,
        public array $state
    ) {

    }
}
