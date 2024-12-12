<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger
    ): Response {
        // Créer une nouvelle instance de l'entité User
        $user = new User();

        // Créer le formulaire basé sur UserType
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Gestion de l'image
            $imageFile = $form->get('imageProfil')->getData();

            if($imageFile)
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('profil_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $user->setImageProfil($newFilename);
            }


            $roleRepository = $entityManager->getRepository(Role::class);
            $role = $roleRepository->findOneBy(['roleId' => '2']);

            if($role)
            {
                $user->setRoleId($role->getRoleId());
                $user->setRolename($role->getRoleName());
            }

            //calculate and define the user Id and custom Id
            $userCount = $entityManager->getRepository(User::class)->count([]);
            $customID = $userCount + 1;
            $user->setCustomId($customID);
            $user->setId($customID);


            // Hashage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);

            // Persister et sauvegarder l'utilisateur
            $entityManager->persist($user);
            $entityManager->flush();

            // Ajouter un message de confirmation (facultatif)
            $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');

            // Rediriger l'utilisateur vers la page de connexion ou autre
            return $this->redirectToRoute('app_login');
        }

        // Afficher le formulaire d'inscription
        return $this->render('register/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
