<?php

declare(strict_types=1);

namespace App\Move\Command\Infrastructure\API\V1;

use App\Move\Command\Domain\Command\CreateMoveCommand;
use App\Shared\Domain\Factory\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MoveController extends AbstractController
{
    public function __construct(
        private MessageBusInterface $bus,
        private CacheInterface $cache
    ) {
    }

    public function move(): Response
    {
        $command = new CreateMoveCommand(
        );

        $this->bus->dispatch($command);

        $this->cache->delete("xxx");

        return ResponseFactory::createSuccessResponse();
    }
}
