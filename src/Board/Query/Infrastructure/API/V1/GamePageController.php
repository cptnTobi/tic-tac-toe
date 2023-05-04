<?php

declare(strict_types=1);

namespace App\Board\Query\Infrastructure\API\V1;

use App\Shared\Domain\Factory\ResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Throwable;

class GamePageController extends AbstractController
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

    public function getPage(Request $request): Response
    {
        try {
          return $this->cache->get("GamePageController", function (ItemInterface $item) {
                $item->expiresAfter(304800);
                 return $this->render('pages/gamePage.html.twig');
            });
        } catch (Throwable $e) {
            return ResponseFactory::createErrorResponse([], $request, $e);
        }
       
    }
}
