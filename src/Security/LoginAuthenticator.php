<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Récupère les informations d'authentification depuis la requête.
     */
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email'); // Récupération de l'email depuis le formulaire
        $password = $request->request->get('_password'); // Récupération du mot de passe depuis le formulaire

        if (!$email) {
            throw new \InvalidArgumentException('L\'email est obligatoire pour l\'authentification.');
        }

        // Retourne un Passport avec UserBadge et PasswordCredentials
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
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath); // Redirection vers la page cible
        }

        return new RedirectResponse($this->router->generate('app_home')); // Redirection par défaut
    }

    /**
     * Retourne l'URL de la page de connexion.
     */
    protected function getLoginUrl(Request $request): string
    {
        return $this->router->generate(self::LOGIN_ROUTE);
    }
}
