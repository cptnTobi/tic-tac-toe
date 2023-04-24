<?php

declare(strict_types=1);

namespace App\Board\Query\Infrastructure\API\V1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Shared\Domain\Model\Uuid;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

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

    public function getPage(): Response
    {
        return $this->render('pages/gamePage.html.twig');
    }
}
