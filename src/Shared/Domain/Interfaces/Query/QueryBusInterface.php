<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces\Query;

interface QueryBusInterface
{
    public function handle(Query $query);
}
