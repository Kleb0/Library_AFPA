<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\LoginAuthenticator;

class ProfileController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;
    private $userAuthenticator;
    private $authenticator;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        LoginAuthenticator $authenticator 
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->userAuthenticator = $userAuthenticator;
        $this->authenticator = $authenticator;
    }

    #[Route('/profil', name: 'app_profile')]
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'image de profil
            $file = $form->get('imageProfil')->getData();
            if ($file) {
                $uploadDir = $this->getParameter('profile_images_directory');

                // Supprimer l'ancienne image si elle existe
                if ($user->getImageProfil()) {
                    $oldFilePath = $uploadDir . '/' . $user->getImageProfil();
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Enregistrer la nouvelle image
                $newFilename = uniqid() . '.' . $file->guessExtension();
                $file->move($uploadDir, $newFilename);
                $user->setImageProfil($newFilename);
            }

            // Mettre à jour le mot de passe
            $plainPassword = $form->get('password')->getData();
            if ($plainPassword) {
                $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
                $user->setPassword($hashedPassword);
            }

            $this->entityManager->flush();

            // Reconnecter l'utilisateur après mise à jour
            $this->userAuthenticator->authenticateUser(
                $user,
                $this->authenticator,
                $request
            );

            $this->addFlash('success', 'Vos informations ont été mises à jour.');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('account/editaccount.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
