<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Exception\BadParameterException;

class StringVO
{
    public function __construct(
        public $value = null
    ) {
        $this->guard($value);
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

    public function equals(StringVO $object): bool
    {
        return $this->value === $object->value();
    }

    private function guard($value)
    {
        if (!is_string($value)) {
            throw BadParameterException::fromData('String value required.');
        }
    }
}
