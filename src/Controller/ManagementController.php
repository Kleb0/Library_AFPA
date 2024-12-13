<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use App\Repository\BookRepository;
use App\Entity\Book;
use App\Entity\BookStatus;
use App\Entity\BookCategory;


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
    #[Route('/admin/books-management', name: 'admin_books_management')]
    public function booksManagement(Request $request, BookRepository $bookRepository, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $books = $bookRepository->findAll();

        // Création d'un formulaire pour ajouter un livre
        $book = new Book();

        //formulaire d'ajout de livre

        $form = $this->createFormBuilder($book)
        ->add('title', TextType::class, [
            'label' => 'Titre',
        ])
        ->add('author', TextType::class, [
            'label' => 'Auteur',
        ])
        ->add('status', EntityType::class, [
            'class' => BookStatus::class,
            'choice_label' => 'name',
            'label' => 'Statut',
        ])
        ->add('isAvailable', CheckboxType::class, [
            'label' => 'Disponible',
            'required' => false,
        ])
        ->add('summary', TextType::class, [ // Ajout du résumé
            'label' => 'Résumé',
            'required' => false,
        ])
        ->add('image', FileType::class, [
            'label' => 'Image (fichier)',
            'mapped' => false, // Ce champ n'est pas lié directement à l'entité
            'required' => false,
            'constraints' => [
                new File([
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPG, JPEG, PNG).',
                ]),
            ],
        ])
        ->add('categories', EntityType::class, [
            'class' => BookCategory::class,
            'choice_label' => 'categoryName',
            'multiple' => true, // Permet de sélectionner plusieurs catégories
            'expanded' => true, // Affiche des cases à cocher au lieu d'une liste déroulante
            'label' => 'Catégories',
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => ['class' => 'btn btn-primary'],
        ])
       
        
        ->add('save', SubmitType::class, [
            'label' => 'Ajouter',
            'attr' => ['class' => 'btn btn-primary'],
        ])
        ->getForm();


       // Traitement du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'image
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                // Générer un nom unique pour l'image
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                // Déplacer le fichier dans le répertoire configuré
                $imageFile->move(
                    $this->getParameter('book_image_directory'),
                    $newFilename
                );

                // Définir le chemin de l'image dans l'entité Book
                $book->setImage('/uploads/book_images/' . $newFilename);
            }

            // Ajout des catégories au livre
            $categories = $form->get('categories')->getData();
            foreach ($categories as $category) {
                $book->addCategory($category);
            }

            // Sauvegarder l'entité Book
            $entityManager->persist($book);
            $entityManager->flush();

            // Rediriger vers la gestion des livres
            return $this->redirectToRoute('admin_books_management');
        }

         // Rendu de la page
        return $this->render('management/bookmanagement.html.twig', [
            'books' => $books,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/delete-book/{id}', name: 'admin_delete_book')]
    public function deleteBook(int $id, BookRepository $bookRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le livre par son ID
        $book = $bookRepository->find($id);

        if (!$book) {
            throw $this->createNotFoundException('Livre introuvable');
        }

        // Supprimer le livre
        $entityManager->remove($book);
        $entityManager->flush();

        // Rediriger vers la gestion des livres
        return $this->redirectToRoute('admin_books_management');
    }

   
}