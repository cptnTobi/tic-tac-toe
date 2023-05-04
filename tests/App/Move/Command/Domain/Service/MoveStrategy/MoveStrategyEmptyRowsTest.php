<?php

namespace App\Tests\App\Move\Command\Domain\Service\MoveStrategy;

use App\Move\Command\Application\DTO\BoardStateDTO;
use App\Move\Command\Domain\Service\MoveStrategy\MoveStrategyEmptyRows;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MoveStrategyEmptyRowsTest extends KernelTestCase
{
    private ContainerInterface $container;
    
    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = static::getContainer();
    }

    public function testgGetBoardReturnsSomething(): void
    {
        $boardStateDTO = new BoardStateDTO([
            [0,0,0],
            [0,0,0],
            [0,0,0]
        ]);

        $moveStrategyEmptyRows = $this->container->get(MoveStrategyEmptyRows::class);
        $result = $moveStrategyEmptyRows->execute($boardStateDTO);

        $this->assertNotEmpty($result);
    }

    public function testgGetBoardReturnsNothingForFull(): void
    {
        $boardStateDTO = new BoardStateDTO([
            [2,2,2],
            [2,2,2],
            [2,2,2]
        ]);

        $moveStrategyEmptyRows = $this->container->get(MoveStrategyEmptyRows::class);
        $result = $moveStrategyEmptyRows->execute($boardStateDTO);

        $this->assertEmpty($result);
    }

    public function testgGetBoardReturnsNothingForPartialFill(): void
    {
        $boardStateDTO = new BoardStateDTO([
            [0,2,2],
            [0,0,0],
            [2,2,0]
        ]);

        $moveStrategyEmptyRows = $this->container->get(MoveStrategyEmptyRows::class);
        $result = $moveStrategyEmptyRows->execute($boardStateDTO);

        $this->assertEmpty($result);
    }

    public function testgGetBoardReturnsOnlyPossibility1(): void
    {
        $boardStateDTO = new BoardStateDTO([
            [2,2,0],
            [2,2,0],
            [2,2,0]
        ]);

        $moveStrategyEmptyRows = $this->container->get(MoveStrategyEmptyRows::class);
        $result = $moveStrategyEmptyRows->execute($boardStateDTO);

        $this->assertsame($result[0]->x->value, 0);
        $this->assertsame($result[0]->y->value, 2);

        $this->assertsame($result[1]->x->value, 1);
        $this->assertsame($result[1]->y->value, 2);

        $this->assertsame($result[2]->x->value, 2);
        $this->assertsame($result[2]->y->value, 2);
    }

    public function testgGetBoardReturnsOnlyPossibility2(): void
    {
        $boardStateDTO = new BoardStateDTO([
            [2,0,2],
            [2,0,2],
            [2,0,2]
        ]);

        $moveStrategyEmptyRows = $this->container->get(MoveStrategyEmptyRows::class);
        $result = $moveStrategyEmptyRows->execute($boardStateDTO);

        $this->assertsame($result[0]->x->value, 0);
        $this->assertsame($result[0]->y->value, 1);

        $this->assertsame($result[1]->x->value, 1);
        $this->assertsame($result[1]->y->value, 1);

        $this->assertsame($result[2]->x->value, 2);
        $this->assertsame($result[2]->y->value, 1);
    }

    public function testgGetBoardReturnsAllPossibilities(): void
    {
        $boardStateDTO = new BoardStateDTO([
            [2,0,0],
            [2,0,0],
            [2,0,0]
        ]);

        $moveStrategyEmptyRows = $this->container->get(MoveStrategyEmptyRows::class);
        $result = $moveStrategyEmptyRows->execute($boardStateDTO);

        $this->assertsame($result[0]->x->value, 0);
        $this->assertsame($result[0]->y->value, 1);

        $this->assertsame($result[1]->x->value, 1);
        $this->assertsame($result[1]->y->value, 1);

        $this->assertsame($result[2]->x->value, 2);
        $this->assertsame($result[2]->y->value, 1);

        $this->assertsame($result[3]->x->value, 0);
        $this->assertsame($result[3]->y->value, 2);

        $this->assertsame($result[4]->x->value, 1);
        $this->assertsame($result[4]->y->value, 2);

        $this->assertsame($result[5]->x->value, 2);
        $this->assertsame($result[5]->y->value, 2);
    }
}
