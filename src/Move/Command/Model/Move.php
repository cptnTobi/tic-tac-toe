<?php

declare(strict_types=1);

namespace App\Move\Command\Model;

use App\Shared\Domain\Model\Uuid;
use App\Move\Command\Model\Coordinates;

final class Move
{
    public function __construct(
        public Uuid $userUuid,
        public Uuid $boardUuid,
        public ?Coordinates $coordinates
    ) {
    }
}
