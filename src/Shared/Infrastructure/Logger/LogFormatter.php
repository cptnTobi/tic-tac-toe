<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Logger;

use Throwable;

class LogFormatter
{
    public static function format(array $extraItems): array
    {
        return self::reduce(self::detectors(), $extraItems, []);
    }

    private static function reduce(callable $fn, $coll, $initial = null)
    {
        $acc = $initial;
        foreach ($coll as $key => $value) {
            $acc = $fn($acc, $value, $key);
        }

        return $acc;
    }

    private static function detectors(): callable
    {
        return function (array $acc, $item): array {
            $formattedLog = $item;

            if ($item instanceof Throwable) {
                $formattedLog = self::formatException($item);
                $previousItem = $item->getPrevious();

                if ($previousItem) {
                    $formattedLog['trace'] = self::exceptionTrace($previousItem);
                }
            }

            return array_merge($acc, $formattedLog);
        };
    }

    private static function formatException(Throwable $exception): array
    {
        $exFormattedLog                   = [];
        $exFormattedLog['exception_body'] = ExceptionLogFormatter::format($exception);

        return $exFormattedLog;
    }

    private static function exceptionTrace(Throwable $exception, array $exFormattedLog = null)
    {
        $exFormattedLog[] = self::formatException($exception);

        $previousException = $exception->getPrevious();
        if ($previousException) {
            $exFormattedLog = self::exceptionTrace($previousException, $exFormattedLog);
        }

        return $exFormattedLog;
    }
}
