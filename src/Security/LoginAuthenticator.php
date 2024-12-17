<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Doctrine\ORM\EntityManagerInterface;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private RouterInterface $router;
    private EventDispatcherInterface $eventDispatcher;
    private EntityManagerInterface $entityManager;

    public function __construct(
        RouterInterface $router,
        EventDispatcherInterface $eventDispatcher,
        EntityManagerInterface $entityManager
    ) {
        $this->router = $router;
        $this->eventDispatcher = $eventDispatcher;
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère les informations d'authentification depuis la requête.
     */
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email'); // Récupération de l'email depuis le formulaire
        $password = $request->request->get('_password'); // Récupération du mot de passe depuis le formulaire

        if (!$email || !$password) {
            throw new \InvalidArgumentException('Email et mot de passe sont requis pour l\'authentification.');
        }

        return new Passport(
            new UserBadge($email), // Identifiant utilisateur (email)
            new PasswordCredentials($password) // Vérification du mot de passe
        );
    }

    /**
     * Action après une authentification réussie.
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();

        // Dispatch de l'événement security.interactive_login
        $event = new InteractiveLoginEvent($request, $token);
        $this->eventDispatcher->dispatch($event);

        // Redirection après authentification réussie
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('app_home')); // Page par défaut après connexion
    }

    /**
     * Retourne l'URL de la page de connexion.
     */
    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate(self::LOGIN_ROUTE);
    }
}
