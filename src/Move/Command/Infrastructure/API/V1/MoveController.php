<?php

declare(strict_types=1);

namespace App\Move\Command\Infrastructure\API\V1;

use App\Move\Command\Domain\Command\CreateAIMoveCommand;
use App\Move\Command\Domain\Command\CreateMoveCommand;
use App\Move\Command\Model\Coordinates;
use App\Move\Command\Model\Move;
use App\Shared\Domain\Factory\ResponseFactory;
use App\Shared\Domain\Model\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    public function move(Request $request): Response
    {
        $data = json_decode($request->getContent());

        $command = new CreateMoveCommand(
            new Move(
                new Uuid($data->user),
                new Uuid($data->board),
                new Coordinates($data->x, $data->y),
            )
        );
        $this->bus->dispatch($command);



        $command = new CreateAIMoveCommand(
            new Move(
                new Uuid('1'),
                new Uuid($data->board),
                null
            )
        );
        $this->bus->dispatch($command);

        $this->cache->delete("xxx");

        return ResponseFactory::createSuccessResponse();
    }
}
