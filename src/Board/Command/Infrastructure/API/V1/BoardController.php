<?php

declare(strict_types=1);

namespace App\Board\Command\Infrastructure\API\V1;

use App\Board\Command\Domain\Command\CreateBoardCommand;
use App\Shared\Domain\Factory\ResponseFactory;
use App\Shared\Domain\Model\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpFoundation\Request;

class BoardController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $bus,
        private CacheInterface $cache
    ) {
    }

    public function create(Request $request, string $id): Response
    {
        try {
            $command = new CreateBoardCommand(
                new Uuid($id)
            );

            $this->bus->dispatch($command);

            $this->cache->delete("boardStatus");

            return ResponseFactory::createSuccessResponse();
        } catch (\Throwable $e) {
            return ResponseFactory::createErrorResponse([], $request, $e);
        }
    }
}
