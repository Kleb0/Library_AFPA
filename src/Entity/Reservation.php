<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "reservations")]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: WorkRoom::class, inversedBy: "reservations")]
    #[ORM\JoinColumn(nullable: false)]
    private ?WorkRoom $workRoom = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null; // La relation correcte avec l'utilisateur

    #[ORM\Column(type: "date")]
    #[Assert\NotNull]
    private ?\DateTimeInterface $reservationDate = null;

    #[ORM\Column(type: "time")]
    #[Assert\NotNull]
    private ?\DateTimeInterface $startTime = null;

    #[ORM\Column(type: "time")]
    #[Assert\NotNull]
    private ?\DateTimeInterface $endTime = null;

    #[ORM\Column(type: "integer")]
    #[Assert\GreaterThan(0)]
    private int $numberOfPeople; // La propriété numberOfPeople doit être indépendante

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWorkRoom(): ?WorkRoom
    {
        return $this->workRoom;
    }

    public function setWorkRoom(?WorkRoom $workRoom): self
    {
        $this->workRoom = $workRoom;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getReservationDate(): ?\DateTimeInterface
    {
        return $this->reservationDate;
    }

    public function setReservationDate(\DateTimeInterface $reservationDate): self
    {
        $this->reservationDate = $reservationDate;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getNumberOfPeople(): int
    {
        return $this->numberOfPeople;
    }

    public function setNumberOfPeople(int $numberOfPeople): self
    {
        $this->numberOfPeople = $numberOfPeople;

        return $this;
    }
}
