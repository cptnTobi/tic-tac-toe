<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

class BoolVO
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
          if (!is_bool($value)) {
              throw BadParameterException();
          }
      }
}
