<?php

declare(strict_types=1);

namespace App\Move\Query\Domain\Query;

use App\Shared\Domain\Interfaces\Query\QueryInterface;

class GetPossibleMovesQuery implements QueryInterface
{
    private const NAME = 'get_possible_moves_query';

    public function __construct(
    ) {
    }

    public static function eventName(): string
    {
        return self::NAME;
    }
}
