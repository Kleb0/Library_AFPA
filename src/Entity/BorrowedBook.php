<?php

namespace App\Entity;

use App\Repository\BorrowedBookRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: BorrowedBookRepository::class)]
class BorrowedBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private int $bookId;

    #[ORM\Column(type: 'string', length: 255)]
    private string $bookName;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $borrowDate;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $returnDate;

    #[ORM\Column(type: 'string', length: 255)]
    private string $borrowedCondition;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $returnedCondition = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $borrowerName;

    #[ORM\ManyToOne(targetEntity: Book::class, inversedBy: 'borrowedBooks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book = null;

    #[ORM\ManyToMany(targetEntity: Book::class, mappedBy: 'borrowedBooks')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addBorrowedBook($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            $book->removeBorrowedBook($this);
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookId(): ?int
    {
        return $this->bookId;
    }

    public function setBookId(int $bookId): self
    {
        $this->bookId = $bookId;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getBookName(): ?string
    {
        return $this->bookName;
    }

    public function setBookName(string $bookName): self
    {
        $this->bookName = $bookName;

        return $this;
    }

    public function getBorrowDate(): ?\DateTimeInterface
    {
        return $this->borrowDate;
    }

    public function setBorrowDate(\DateTimeInterface $borrowDate): self
    {
        $this->borrowDate = $borrowDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getBorrowedCondition(): ?string
    {
        return $this->borrowedCondition;
    }

    public function setBorrowedCondition(string $borrowedCondition): self
    {
        $this->borrowedCondition = $borrowedCondition;

        return $this;
    }

    public function getReturnedCondition(): ?string
    {
        return $this->returnedCondition;
    }

    public function setReturnedCondition(?string $returnedCondition): self
    {
        $this->returnedCondition = $returnedCondition;

        return $this;
    }

    public function getBorrowerName(): ?string
    {
        return $this->borrowerName;
    }

    public function setBorrowerName(string $borrowerName): self
    {
        $this->borrowerName = $borrowerName;

        return $this;
    }
}
