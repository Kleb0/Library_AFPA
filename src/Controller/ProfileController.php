<?php

namespace App\Controller;

use App\Entity\ModifiedProfileImage;
use App\Form\ModifyImageType;
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

    #[Route('/profil/image', name: 'app_profile_image')]
    public function editImage(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $modifyUser = $this->entityManager
            ->getRepository(ModifyUser::class)
            ->findOneBy(['user' => $user]);

        if (!$modifyUser) {
            $modifyUser = new ModifyUser();
            $modifyUser->setUser($user);
        }

        $form = $this->createForm(ModifyImageType::class, $modifyUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();

            if ($uploadedFile) {
                // Générer un nom de fichier unique
                $newFilename = uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $this->getParameter('modify_user_images_directory'),
                    $newFilename
                );

                // Créer une nouvelle entité ModifiedProfileImage
                $modifiedImage = new ModifiedProfileImage();
                $modifiedImage->setImagePath($newFilename);
                $modifiedImage->setModifyUser($modifyUser);

                // Mettre à jour l'image actuelle dans l'entité User
                $user->setImageProfil($newFilename);

                // Persiste les modifications
                $this->entityManager->persist($modifiedImage);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->addFlash('success', 'Votre image de profil a été mise à jour.');
                return $this->redirectToRoute('app_account'); // Redirige vers la page du compte
            }
        }

        return $this->render('account/modifyimage.html.twig', [
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
