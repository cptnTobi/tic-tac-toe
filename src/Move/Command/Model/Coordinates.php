<?php

declare(strict_types=1);

namespace App\Move\Command\Model;

use App\Shared\Domain\Model\IntVO;

final class Coordinates
{
    public IntVO $x;
    public IntVO $y;

    public function __construct(
        private $coordX,
        private $coordY
    ) {
        $this->guard($coordX);
        $this->guard($coordY);

        $this->x = new IntVO($coordX);
        $this->y = new IntVO($coordY);
    }

    private function guard(int $value)
    {
        if ($value < 0) {
            throw BadParameterException::fromData('Wrong parameter provided: Coordinates cannot be negative.');
        }

        if ($value > 20) {
            throw BadParameterException::fromData('Wrong parameter provided: Coordinates must be less than 20');
        }
    }
}
