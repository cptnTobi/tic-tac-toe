<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

class ArrayVO
{
    public function __construct(
        public array $value
    ) {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
