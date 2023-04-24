<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Logger;

interface BaseLoggerInterface
{
    public function info(string $message, ...$extraItems): void;

    public function warning(string $message, ...$extraItems): void;

    public function critical(string $message, ...$extraItems): void;
}
