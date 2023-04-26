<?php

namespace App\Tests\App\Move\Command\Domain\Service\MoveStrategy;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Move\Command\Domain\Service\MoveStrategy\MoveStrategyEmptyRows;
use App\Board\Query\Domain\Interfaces\WinnerStrategyInterface;
use App\Move\Command\Application\DTO\BoardStateDTO;
use App\Move\Command\Domain\Interfaces\MoveStrategyInterface;
use App\Move\Command\Model\Coordinates;
use App\Shared\Domain\Exception\BadParameterException;

class MoveStrategyEmptyRowsTest extends KernelTestCase
{
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

    public function testgGetBoardReturnsNothing(): void
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

    public function testgGetBoardReturnsOnlyPossibility(): void
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
}
