<?php

declare(strict_types=1);

namespace App\Move\Command\Application\DTO;

class BoardStateDTO
{
    public function __construct(
        public array $state
    ) {

    }
}
