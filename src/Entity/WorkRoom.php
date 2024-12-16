<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "work_rooms")]
class WorkRoom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', unique: true, nullable: true)]
    private ?int $customId = null;

    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank]
    #[Assert\GreaterThan(0, message: "Le nombre maximal de personnes doit être supérieur à 0.")]
    private int $maxCapacity;

    #[ORM\Column(type: "json")]
    private array $equipment = [];

    #[ORM\Column(type: "date")]
    #[Assert\NotNull]
    private ?\DateTimeInterface $startReservationDate = null;

    #[ORM\Column(type: "date")]
    #[Assert\NotNull]
    private ?\DateTimeInterface $endReservationDate = null;

    #[ORM\Column(type: "simple_array", nullable: true)]
    private ?array $excludedDays = [];

    #[ORM\Column(type: "time")]
    #[Assert\NotNull]
    private ?\DateTimeInterface $minReservationTime = null;

    #[ORM\Column(type: "time")]
    #[Assert\NotNull]
    private ?\DateTimeInterface $maxReservationTime = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: "reservedRooms")]
    private Collection $users;
    
    #[ORM\OneToMany(mappedBy: "workRoom", targetEntity: Reservation::class, cascade: ["remove"], orphanRemoval: true)]
    private Collection $reservations;

    #[ORM\Column(type: "boolean")]
    private bool $available = true;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->excludedDays = [];
        $this->reservations = new ArrayCollection();
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }
    
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMaxCapacity(): int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(int $maxCapacity): self
    {
        $this->maxCapacity = $maxCapacity;

        return $this;
    }

    public function getEquipment(): array
    {
        return $this->equipment;
    }

    public function setEquipment(array $equipment): self
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function getStartReservationDate(): ?\DateTimeInterface
    {
        return $this->startReservationDate;
    }

    public function setStartReservationDate(\DateTimeInterface $startReservationDate): self
    {
        $this->startReservationDate = $startReservationDate;

        return $this;
    }

    public function getEndReservationDate(): ?\DateTimeInterface
    {
        return $this->endReservationDate;
    }

    public function setEndReservationDate(\DateTimeInterface $endReservationDate): self
    {
        $this->endReservationDate = $endReservationDate;

        return $this;
    }

    public function getExcludedDays(): ?array
    {
        return $this->excludedDays;
    }

    public function setExcludedDays(?array $excludedDays): self
    {
        $this->excludedDays = $excludedDays;

        return $this;
    }

    public function getMinReservationTime(): ?\DateTimeInterface
    {
        return $this->minReservationTime;
    }

    public function setMinReservationTime(\DateTimeInterface $minReservationTime): self
    {
        $this->minReservationTime = $minReservationTime;

        return $this;
    }

    public function getMaxReservationTime(): ?\DateTimeInterface
    {
        return $this->maxReservationTime;
    }

    public function setMaxReservationTime(\DateTimeInterface $maxReservationTime): self
    {
        $this->maxReservationTime = $maxReservationTime;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addReservedRoom($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeReservedRoom($this);
        }

        return $this;
    }
}
