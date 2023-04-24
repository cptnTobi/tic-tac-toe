<?php

declare(strict_types=1);

namespace App\Board\Command\Domain\Command;

use App\Shared\Domain\Interfaces\Command\CommandInterface;
use App\Shared\Domain\Model\Uuid;

class CreateBoardCommand implements CommandInterface
{
    private const NAME = 'create_board_command';

    public function __construct(
        public Uuid $uuid
    ) {
    }

    public static function eventName(): string
    {
        return self::NAME;
    }
}
