<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity]
#[ORM\Table(name: "users")]
#[UniqueEntity(fields: ["email"], message: "Cet email existe déjà.")]
#[UniqueEntity(fields: ["nom"], message: "Ce nom est déjà utilisé.")]
#[UniqueEntity(fields: ["adresse"], message: "Cette adresse est déjà utilisée.")]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private $nom;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private $prenom;

    #[ORM\Column(type: "date")]
    #[Assert\NotNull]
    private $dateNaissance;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private $email;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private $password;

    #[ORM\Column(type: "string", length: 255)]
    private $adresse;

    #[ORM\Column(type: "string", length: 10)]
    private $codePostal;

    #[ORM\Column(type: "string", length: 255)]
    private $ville;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private $telephone;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $imageProfil;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private $rolename;

    #[ORM\Column(type: "integer", nullable: true)]
    private $roleId;

    // Méthodes de UserInterface
    public function getRoles(): array
    {
        // Retourne un tableau contenant les rôles de l'utilisateur
        return ['ROLE_USER'];
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        // Si vous utilisez bcrypt ou sodium, le sel n'est pas nécessaire
        return null;
    }

    public function getUsername(): string
    {
        // Utiliser l'email comme identifiant
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // Effacer les données sensibles (par exemple, les mots de passe en clair)
    }

    // Getters et setters existants
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getImageProfil(): ?string
    {
        return $this->imageProfil;
    }

    public function setImageProfil(?string $imageProfil): self
    {
        $this->imageProfil = $imageProfil;

        return $this;
    }

    public function getRolename(): ?string
    {
        return $this->rolename;
    }

    public function setRolename(?string $rolename): self
    {
        $this->rolename = $rolename;

        return $this;
    }

    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    public function setRoleId(?int $roleId): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    // Méthode pour retourner l'identifiant principal de l'utilisateur
    public function getUserIdentifier(): string
    {
        // Utiliser l'email comme identifiant principal
        return $this->email;
    }
}
