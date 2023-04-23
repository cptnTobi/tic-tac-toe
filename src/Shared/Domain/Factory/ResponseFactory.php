<?php

declare(strict_types=1);

namespace App\Shared\Domain\Factory;

use App\Shared\Domain\Interfaces\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ResponseFactory implements ResponseInterface
{
    public static function createSuccessResponse(array $data = null, int $code = Response::HTTP_OK): Response
    {
        if (empty($data)) {
            return new JsonResponse([], $code);
        }

        return new JsonResponse($data, $code);
    }

    public static function createErrorResponse(array $data = [], ?Request $request = null, ?Throwable $e = null, ?int $code = null): Response
    {
        $code = $code ?? $e?->getCode() ?? Response::HTTP_SERVICE_UNAVAILABLE;
        if ($request === null) {
            return new Response(null, $code);
        }

        return new JsonResponse(
            array_merge([
                'message' => $e?->getMessage() ?? '',
                'code' => $code,
                'data' => [
                    'parameter' => $request->request->all(),
                    'content' => json_decode($request->getContent(), true),
                    'ContentType' => $request->getContentTypeFormat(),
                    'AcceptableContentTypes' => $request->getAcceptableContentTypes()
                ]
                    ], $data),
            $code
        );
    }
}
