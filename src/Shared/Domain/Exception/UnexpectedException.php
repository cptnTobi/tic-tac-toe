<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Throwable;

class UnexpectedException extends ApplicationException
{
    private const MESSAGE = 'Unexpected error occurred.';
    private const CODE = 503;

    public static function fromData(?string $message = null, ?Throwable $previous = null, ?array $data = []): self
    {
        return new self($message ?? self::MESSAGE, self::CODE, $previous, ['data' => $data]);
    }
}
