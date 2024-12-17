<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, SessionInterface $session, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        // $session->set('test_key', 'session fonctionne');
        // dump($session->get('test_key')); // Vérifie la valeur
        // die();

        // $session->set('test_key', 'session fonctionne');
        // dump($session->get('test_key')); // Vérifie la valeur de session
        
        // // Générer le CSRF token
        // $csrfToken = $csrfTokenManager->getToken('authenticate')->getValue();
        // dump('CSRF Token : ' . $csrfToken);
        // dump($session->getId());
        // dump($csrfTokenManager->getToken('authenticate')->getValue());
        // die();

        

        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony gère automatiquement la déconnexion.
    }
}
