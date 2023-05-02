<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use Symfony\Component\Uid\Uuid;

class UrlVO extends StringVO
{
    public function __construct(
        public $value = null
    ) {
        $this->guard($value);

        parent::__construct($value);
    }

    private function guard($value): void
    {
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw BadParameterException::fromData('Url required.');
        }
    }
}
