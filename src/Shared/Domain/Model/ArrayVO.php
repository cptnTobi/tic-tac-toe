<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Exception\BadParameterException;

class ArrayVO
{
    public function __construct(
        public $value
    ) {
        $this->guard($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
     private function guard($value): void
     {
         if (!is_array($value)) {
             throw BadParameterException();
         }
     }
}
