<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $author;

    #[ORM\ManyToOne(targetEntity: BookStatus::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private $status;

    #[ORM\Column(type: 'boolean')]
    private $isAvailable = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getStatus(): ?BookStatus
    {
        return $this->status;
    }

    public function setStatus(?BookStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }

    public function setAvailability(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function borrow(): void
    {
        if (!$this->isAvailable) {
            throw new \Exception('The book is not available.');
        }
        $this->isAvailable = false;
    }

    public function returnBook(): void
    {
        $this->isAvailable = true;
    }
}
