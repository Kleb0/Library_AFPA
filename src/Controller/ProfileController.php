<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\ModifyUser;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/profil', name: 'app_profile')]
    #[Route('/profil', name: 'app_profile')]
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // On cherche un ModifyUser existant ou on en crée un nouveau
        $modifyUser = $this->entityManager
            ->getRepository(ModifyUser::class)
            ->findOneBy(['user' => $user]);

        if (!$modifyUser) {
            $modifyUser = new ModifyUser();
            $modifyUser->setUser($user);
        }

        $form = $this->createForm(ProfileType::class, $modifyUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On persiste les modifications
            $this->entityManager->persist($modifyUser);
            $this->entityManager->flush();

            $this->addFlash('success', 'Vos informations ont été mises à jour.');
            return $this->redirectToRoute('app_profile_confirm');
        }

        return $this->render('account/editaccount.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/profil/confirm', name:'app_profile_confirm')]
    public function confirmEdit(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
    
        // Si le mot de passe est soumis
        if ($request->isMethod('POST')) {
            $this->addFlash('success', 'Vos informations ont été confirmées. Vous allez être déconnecté.');
            return $this->redirectToRoute('app_logout'); // Redirige pour déconnecter
        }
    
        return $this->render('account/confirmedit.html.twig');

    }
}
