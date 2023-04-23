<?php

declare(strict_types=1);

namespace App\Move\Command\Domain\Command;

use App\Shared\Domain\Interfaces\Command\CommandInterface;

class CreateMoveCommand implements CommandInterface
{
    private const NAME = 'create_move_command';

    public function __construct(

    ) {
    }

    public static function eventName(): string
    {
        return self::NAME;
    }
}
