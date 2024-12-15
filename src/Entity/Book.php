<?php

namespace App\Entity;


use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


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
    private ?BookStatus $status = null;

    #[ORM\Column(type: 'integer', unique: true, nullable: false)]
    private $customId;


    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $summary = null;

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }


    #[ORM\Column(type: 'boolean')]
    private $isAvailable = true;



    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $image = null;

    public function getImage(): ?string
    {
        return $this->image;
    }

    #[ORM\ManyToMany(targetEntity: BookCategory::class, inversedBy: 'books')]
    #[ORM\JoinTable(name: 'book_book_category')] // Nom de la table de liaison (facultatif)
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: BorrowedBook::class, inversedBy: 'books')]
    #[ORM\JoinTable(name: 'book_borrowed_book')] // Table de liaison
    private Collection $borrowedBooks;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->borrowedBooks = new ArrayCollection();
        $this->borrowHistories = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(BookCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(BookCategory $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // Set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    #[ORM\ManyToMany(targetEntity: BorrowHistory::class, mappedBy: 'books')]
    private Collection $borrowHistories;

    public function getBorrowHistories(): Collection
    {
        return $this->borrowHistories;
    }

    public function addBorrowHistory(BorrowHistory $borrowHistory): self
    {
        if (!$this->borrowHistories->contains($borrowHistory)) {
            $this->borrowHistories[] = $borrowHistory;
            $borrowHistory->addBook($this);
        }

        return $this;
    }

    public function removeBorrowHistory(BorrowHistory $borrowHistory): self
    {
        if ($this->borrowHistories->removeElement($borrowHistory)) {
            $borrowHistory->removeBook($this);
        }

        return $this;
    }





    public function getBorrowedBooks(): Collection
    {
        return $this->borrowedBooks;
    }

    public function addBorrowedBook(BorrowedBook $borrowedBook): self
    {
        if (!$this->borrowedBooks->contains($borrowedBook)) {
            $this->borrowedBooks->add($borrowedBook);
        }

        return $this;
    }

    public function removeBorrowedBook(BorrowedBook $borrowedBook): self
    {
        $this->borrowedBooks->removeElement($borrowedBook);

        return $this;
    }

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $bookCondition = null;

    public function getBookCondition(): ?string
    {
        return $this->bookCondition;
    }

    public function setBookCondition(?string $bookCondition): self
    {
        $this->bookCondition = $bookCondition;

        return $this;
    }


    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
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

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $categoryIdList = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $categoryNameList = null;

    public function getCategoryIdList(): ?string
    {
        return $this->categoryIdList;
    }

    public function setCategoryIdList(?string $categoryIdList): self
    {
        $this->categoryIdList = $categoryIdList;

        return $this;
    }

    public function getCategoryNameList(): ?string
    {
        return $this->categoryNameList;
    }

    public function setCategoryNameList(?string $categoryNameList): self
    {
        $this->categoryNameList = $categoryNameList;

        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }



    public function getCustomId(): ?int
    {
        return $this->customId;
    }

    public function setCustomId(int $customId): self
    {
        $this->customId = $customId;

        return $this;
    }


    
}
