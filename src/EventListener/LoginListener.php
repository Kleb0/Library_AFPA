<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ModifyUser;
use App\Entity\User;

class LoginListener implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
        ];
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();
      
        // Vérifie si l'utilisateur est une instance de User
        if (!$user instanceof User) {
            return;
        }
        

        // Recherche si un ModifyUser existe pour cet utilisateur
        $modifyUser = $this->entityManager->getRepository(ModifyUser::class)
            ->findOneBy(['user' => $user]);

        if ($modifyUser) {
            // Remplace les données dans User si ModifyUser existe
            if ($modifyUser->getNom()) {
                $user->setNom($modifyUser->getNom());
            }
            if ($modifyUser->getPrenom()) {
                $user->setPrenom($modifyUser->getPrenom());
            }
            if ($modifyUser->getEmail()) {
                $user->setEmail($modifyUser->getEmail());
            }
            if ($modifyUser->getAdresse()) {
                $user->setAdresse($modifyUser->getAdresse());
            }
            if ($modifyUser->getVille()) {
                $user->setVille($modifyUser->getVille());
            }
            if ($modifyUser->getCodePostal()) {
                $user->setCodePostal($modifyUser->getCodePostal());
            }

            // Supprime ModifyUser après la mise à jour
            $this->entityManager->remove($modifyUser);

            // Persiste et sauvegarde les modifications
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
    }
}
