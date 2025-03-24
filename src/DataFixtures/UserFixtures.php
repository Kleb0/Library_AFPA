<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();

        // ⚠️ On définit l'ID manuellement, car l'entité ne génère pas automatiquement
        $user->setId(1);

        $user->setNom('Testeur');
        $user->setPrenom('Jean');
        $user->setDateNaissance(new \DateTime('1990-01-01'));
        $user->setEmail('test@example.com');
        $user->setAdresse('1 rue du test');
        $user->setCodePostal('75001');
        $user->setVille('Paris');
        $user->setTelephone('0601020304');
        $user->setRolename('Admin');
        $user->setRoleId(1);
        $user->setCustomId(123);

        $hashedPassword = $this->passwordHasher->hashPassword($user, 'password123');
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}
