<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: "subscriptions")]
    private Collection $users;
    
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    
    public function getUsers(): Collection
    {
        return $this->users;
    }
    
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addSubscription($this);
        }
    
        return $this;
    }
    
    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeSubscription($this);
        }
    
        return $this;
    }
    


}
