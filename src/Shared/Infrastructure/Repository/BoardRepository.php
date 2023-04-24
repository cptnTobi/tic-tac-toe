<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Shared\Domain\Entity\Board;
use App\Shared\Domain\Model\Uuid;

class BoardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Board::class);
    }

    public function removeAll(): void
    {
        $entities = $this->findAll();
        $entityManager = $this->getEntityManager();
        foreach ($entities as $entity) {
            $entityManager->remove($entity);
        }

        $entityManager->flush();
    }

    public function save(Board $entity): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($entity);

        $entityManager->flush();
    }

    public function update($entity): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->merge($entity);

        $entityManager->flush();
    }

    public function remove($entity): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($entity);

        $entityManager->flush();
    }

    public function getBoard(Uuid $uuid): ?Board
    {
        return $this->findOneById($uuid->value);
    }
}
