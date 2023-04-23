<?php

declare(strict_types=1);

namespace App\Move\Query\Infrastructure\API\V1;

use App\Shared\Domain\Factory\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Move\Query\Domain\Query\GetPossibleMovesQuery;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class MoveController extends AbstractController
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(
        private MessageBusInterface $queryBus,
        private CacheInterface $cache
    ) {
        $this->messageBus = $queryBus;
    }

    public function getPossibleMoves(): Response
    {
        /**
        $value = $this->cache->get("xxx", function (ItemInterface $item) {
            $item->expiresAfter(304800);
            return '';
        });
        **/

        $query = new GetPossibleMovesQuery(

        );
        $possibleMovesDTO = $this->handleQuery($query);

        return ResponseFactory::createSuccessResponse([
            'data' => json_decode(json_encode($possibleMovesDTO), true)
        ]);
    }
}
