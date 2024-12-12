<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ManagementController extends AbstractController
{
    #[Route('/admin', name: 'admin_users_management')]
    public function usersManagement(UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $users = $userRepository->findAll();

        return $this->render('management/usermanagement.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/edit-role/{id}', name: 'admin_edit_role')]
    public function editRole(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur introuvable');
        }

        // Logique pour modifier le rôle
        if ($user->getRolename() === 'Admin') {
            $user->setRolename('Utilisateur');
        } else {
            $user->setRolename('Admin');
        }

        // Sauvegarder les modifications
        $entityManager->flush();

        // Rediriger vers la page de gestion des utilisateurs
        return $this->redirectToRoute('admin_users_management');
    }

    #[Route('/admin/ban-user/{id}', name: 'admin_ban_user')]
    public function banUser(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur introuvable');
        }

        // Supprimer l'utilisateur
        $entityManager->remove($user);
        $entityManager->flush();

        // Rediriger vers la page de gestion des utilisateurs
        return $this->redirectToRoute('admin_users_management');
    }
}
