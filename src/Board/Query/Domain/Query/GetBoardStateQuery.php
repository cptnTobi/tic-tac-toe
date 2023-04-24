<?php

declare(strict_types=1);

namespace App\Board\Query\Domain\Query;

use App\Shared\Domain\Interfaces\Query\QueryInterface;
use App\Shared\Domain\Model\Uuid;

class GetBoardStateQuery implements QueryInterface
{
    private const NAME = 'get_board_state_query';

    public function __construct(
        public Uuid $uuid
    ) {
    }

    public static function eventName(): string
    {
        return self::NAME;
    }
}
