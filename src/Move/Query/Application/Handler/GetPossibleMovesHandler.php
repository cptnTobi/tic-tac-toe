<?php

declare(strict_types=1);

namespace App\Move\Query\Application\Handler;

use App\Move\Query\Domain\Query\GetPossibleMovesQuery;
use App\Shared\Domain\Interfaces\Query\QueryHandlerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetPossibleMovesHandler implements QueryHandlerInterface
{
    public function __construct(

    ) {
    }

    public function __invoke(GetPossibleMovesQuery $query)
    {

    }
}
