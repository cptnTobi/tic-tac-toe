<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Logger;

use Exception;
use Traversable;

final class ExceptionLogFormatter
{
    /** @param Exception $exception */
    public static function format($exception): array
    {
        $code = method_exists($exception, 'errorCode') ? $exception->errorCode() : $exception->getCode();

        return [
            'exception_class'   => (string) get_class($exception),
            'exception_file'    => (string) $exception->getFile(),
            'exception_line'    => (int) $exception->getLine(),
            'exception_code'    => (string) is_numeric($code) ? sprintf('Num: %s', $code) : $code,
            'exception_trace'   => (string) self::reduce(self::exceptionNormalizer(), $exception->getTrace(), ''),
            'exception_message' => (string) $exception->getMessage(),
        ];
    }

    private static function reduce(callable $fn, $coll, $initial = null)
    {
        $acc = $initial;

        foreach ($coll as $key => $value) {
            $acc = $fn($acc, $value, $key);
        }

        return $acc;
    }

    private static function exceptionNormalizer()
    {
        return function ($trace, array $traceLine, $key) {
            if ('' !== $trace) {
                $trace .= PHP_EOL;
            }

            return $trace; // TODO: remove that line and enhance by the following lines.

            $file          = self::get('file', $traceLine, '');
            $formattedFile = null !== $file ? self::formatFile($file) : 'Callable';

            return $trace . sprintf('%s) %s:%s', $key, $formattedFile, self::get('line', $traceLine, '?'));
        };
    }

    private static function get($key, $coll, $default = null)
    {
        return is_array($coll)
            ? self::_get_array($key, $coll, $default)
            : self::_get_traversable(
                $key,
                $coll,
                $default
            );
    }

    private static function _get_array($key, array $coll, $default): bool
    {
        return array_key_exists($key, $coll) ? $coll[$key] : $default;
    }

    private static function _get_traversable($key, Traversable $coll, $default)
    {
        foreach ($coll as $k => $v) {
            if ($key == $k) {
                return $v;
            }
        }

        return $default;
    }

    private static function formatFile(string $file): string
    {
        $basePath = realpath(__DIR__ . '/../../..');

        return str_replace($basePath . '/', '', $file);
    }
}
