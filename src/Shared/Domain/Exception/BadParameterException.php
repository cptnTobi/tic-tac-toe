<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Throwable;

class BadParameterException extends DomainException
{
    private const MESSAGE = 'Bad parameter provided.';
    private const CODE = 400;

    public static function fromData(?string $message = null, ?Throwable $previous = null, ?array $data = []): self
    {
        return new self($message ?? self::MESSAGE, self::CODE, $previous, ['data' => $data]);
    }
}
