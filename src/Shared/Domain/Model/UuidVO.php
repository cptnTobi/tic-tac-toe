<?php

declare(strict_types=1);

namespace App\Shared\Domain\Model;

use Symfony\Component\Uid\Uuid;

class UuidVO extends StringVO
{
    public function __construct(
        public $value = null
    ) {
        if (empty($value)) {
            $value =  Uuid::V7()->toHex();
        }

        parent::__construct($value);
    }
}
