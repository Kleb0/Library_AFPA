<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class AccountControllerTest extends WebTestCase
{
    public function testRedirectIfNotLoggedIn(): void
    {
        $client = static::createClient();
        $client->request('GET', '/account');

        $this->assertResponseRedirects('/login');
    }

    public function testAccessAccountPageWhenLoggedIn(): void
    {
        $client = static::createClient();

        // Récupère le UserRepository
        $userRepository = static::getContainer()->get(UserRepository::class);

        // Récupère l'utilisateur inséré via la fixture
        $testUser = $userRepository->findOneByEmail('test@example.com');

        // Connecte l'utilisateur
        $client->loginUser($testUser);

        // Accès à /account
        $crawler = $client->request('GET', '/account');

        // Vérifie que la page est bien accessible
        $this->assertResponseIsSuccessful();

        // Vérifie que l'email s'affiche dans le HTML
        $this->assertSelectorTextContains('body', $testUser->getEmail());
    }
}