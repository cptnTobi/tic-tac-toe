<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Logger;

use Psr\Log\LoggerInterface;

final class BaseLogger implements BaseLoggerInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function info(string $message, ...$extraItems): void
    {
        $this->logger->info($message, $this->getInfoToLog($extraItems));
    }

    private function getInfoToLog(array $extraItems): array
    {
        return LogFormatter::format($extraItems);
    }

    public function warning(string $message, ...$extraItems): void
    {
        $this->logger->warning($message, $this->getInfoToLog($extraItems));
    }

    public function critical(string $message, ...$extraItems): void
    {
        $this->logger->critical($message, $this->getInfoToLog($extraItems));
    }
}
