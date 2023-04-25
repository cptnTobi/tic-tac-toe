<?php

declare(strict_types=1);

namespace App\Board\Query\Domain\Query;

use App\Shared\Domain\Interfaces\Query\QueryInterface;
use App\Board\Query\Model\BoardState;
use App\Board\Query\Application\DTO\BoardStateDTO;

class GetBoardStatusQuery implements QueryInterface
{
    private const NAME = 'get_board_status_query';

    public function __construct(
        public BoardStateDTO $boardStateDTO
    ) {
    }

    public static function eventName(): string
    {
        return self::NAME;
    }
}
