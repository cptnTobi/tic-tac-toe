<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Exception\BadParameterException;

class FloatVO
{
    public function __construct(
        public  $value
    ) {
        $this->guard($value);
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public function equals(self $object): bool
    {
        return $this->value === $object->value();
    }

          private function guard($value): void
          {
              if (!is_float($value)) {
                 throw BadParameterException::fromData('Float value required.');
              }
          }
}
