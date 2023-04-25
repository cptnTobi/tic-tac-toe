<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Command;

use App\Shared\Domain\Interfaces\Command\CommandInterface;
use App\Move\Command\Model\Move;

class CreateAIMoveCommand implements CommandInterface
{
    private const NAME = 'create_ai_move_command';

    public function __construct(
        public Move $move
    ) {
    }

    public static function eventName(): string
    {
        return self::NAME;
    }
}
