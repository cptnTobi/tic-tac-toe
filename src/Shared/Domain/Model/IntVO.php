<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

class IntVO
{
    public function __construct(
        public int $value
    ) {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function equals(IntVO $object): bool
    {
        return $this->value === $object->value();
    }
}
