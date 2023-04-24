<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Infrastructure\Repository\BoardRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

#[ORM\Entity(repositoryClass: BoardRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Board
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private string $id;

    #[Column(type: 'json')]
    private string $state;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtAtValue(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}
