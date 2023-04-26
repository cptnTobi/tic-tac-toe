<?php

namespace App\Tests\App\Board\Query\Domain\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Shared\Domain\Entity\Board;
use App\Shared\Domain\Model\Uuid;
use App\Shared\Infrastructure\Repository\BoardRepository;
use App\Board\Query\Domain\Service\BoardService;

class BoardServiceTest extends KernelTestCase
{
    public $container;
    public BoardRepository $boardRepository;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = static::getContainer();
        $this->boardRepository = $this->createMock(BoardRepository::class);
    }

    public function testgGetBoard(): void
    {
        $uuid = new Uuid(md5(rand()));
        $board = new Board();
        $board->setId($uuid->value);

        $this->boardRepository->expects(self::once())
               ->method('getBoard')
               ->willReturn($board);

        $this->container->set(BoardRepository::class, $this->boardRepository);
        $boardService = $this->container->get(BoardService::class);

        $result = $boardService->getBoard($uuid);

        $this->assertSame($uuid->value, $result->getId());
    }
}
