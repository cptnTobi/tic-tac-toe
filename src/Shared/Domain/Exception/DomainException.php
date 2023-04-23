<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

use Exception;
use Throwable;

class DomainException extends Exception
{
    protected $extraItems = [];

    final public function __construct(string $message = "", int $code = 0, Throwable $previous = null, array $extraItems = [])
    {
        $this->extraItems = $extraItems;
        parent::__construct($message, $code, $previous);
    }

    public static function withMessageAndExtraItems(string $message, array $extraItems)
    {
        return new static($message, $code = 0, $previous = null, $extraItems);
    }

    public function withAddedExtraItems(array $extraItems): self
    {
        return new static(
            $this->getMessage(),
            $this->getCode(),
            $this->getPrevious(),
            array_merge($extraItems, $this->getExtraItems())
        );
    }

    public function getExtraItems(): array
    {
        return $this->extraItems;
    }
}
