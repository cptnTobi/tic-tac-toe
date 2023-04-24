<?php

declare(strict_types=1);

namespace App\Board\Query\Infrastructure\API\V1;

use App\Board\Query\Domain\Query\GetBoardStateQuery;
use App\Shared\Domain\Factory\ResponseFactory;
use App\Shared\Domain\Model\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\CacheInterface;

class BoardStateController extends AbstractController
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

    public function getPage(): Response
    {
        return $this->render('pages/gamePage.html.twig');
    }

    public function getBoardState(string $id): Response
    {
        /**
        $value = $this->cache->get("xxx", function (ItemInterface $item) {
            $item->expiresAfter(304800);
            return '';
        });
        **/

        $query = new GetBoardStateQuery(
            new Uuid($id)
        );
        $possibleMovesDTO = $this->handleQuery($query);

        return ResponseFactory::createSuccessResponse([
            'data' => json_decode(json_encode($possibleMovesDTO), true)
        ]);
    }
}
