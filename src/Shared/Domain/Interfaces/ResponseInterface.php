<?php

declare(strict_types=1);

namespace App\Shared\Domain\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

interface ResponseInterface
{
    public static function createSuccessResponse(array $data = null, int $code = Response::HTTP_OK): Response;

    public static function createErrorResponse(array $data = [], ?Request $request = null, ?Throwable $e = null, ?int $code = null): Response;
}
