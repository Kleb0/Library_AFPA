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
use App\Repository\BorrowHistoryRepository;


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

    
    // Gestion des livres
    #[Route('/admin/books-management', name: 'admin_books_management')]
    public function booksManagement(Request $request, BookRepository $bookRepository, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        $books = $bookRepository->findAll();
        $book = new Book();
        $category = new BookCategory(); // Nouvelle catégorie


        $bookForm = $this->createFormBuilder($book)
        ->add('title', TextType::class, [
            'label' => 'Titre',
        ])
        ->add('author', TextType::class, [
            'label' => 'Auteur',
        ])
        ->add('isAvailable', CheckboxType::class, [
            'mapped' => false,
            'required' => false,
            'label' => 'Disponibilité',
            'data' => true, // Par défaut disponible
        ])
        ->add('summary', TextType::class, [
            'label' => 'Résumé',
            'required' => false,
        ])
        ->add('image', FileType::class, [
            'label' => 'Image (fichier)',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new File([
                    'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/png'],
                    'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPG, JPEG, PNG).',
                ]),
            ],
        ])
        ->add('categories', EntityType::class, [
            'class' => BookCategory::class,
            'choice_label' => 'categoryName',
            'multiple' => true,
            'expanded' => true,
            'label' => 'Catégories',
        ])
        ->add('status', EntityType::class, [
            'class' => BookStatus::class,
            'choice_label' => 'name',
            'label' => 'État du livre',
            'placeholder' => 'Choisir un état',
            'required' => true,
        ])
        // ->add('bookCondition', TextType::class, [ // Ajout du champ
        //     'label' => 'État du livre',
        //     'required' => false,
        // ])f
        ->add('save', SubmitType::class, [
            'label' => 'Ajouter le livre',
            'attr' => ['class' => 'btn btn-primary'],
        ])
        ->getForm();

        // Formulaire pour créer une catégorie
        $categoryForm = $this->createFormBuilder($category)
        ->add('categoryName', TextType::class, [
            'label' => 'Nom de la catégorie',
            'mapped' => true
        ])

        ->add('save', SubmitType::class, [
            'label' => 'Créer une catégorie',
            'attr' => ['class' => 'btn btn-secondary'],
        ])
        ->getForm();

        // Traitement des formulaires
        $bookForm->handleRequest($request);
        $categoryForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            
        $book->setAvailability($bookForm->get('isAvailable')->getData());

        // Gestion de l'image
        $imageFile = $bookForm->get('image')->getData();        
        if ($imageFile) 
        {
            $newFilename = uniqid() . '.' . $imageFile->guessExtension();
            $imageFile->move($this->getParameter('book_image_directory'), $newFilename);
            $book->setImage('/uploads/book_images/' . $newFilename);
        }

        // //Gestion de la condition du livre
        // $book->setBookCondition($bookForm->get('bookCondition')->getData());

        $nextCustomId = $bookRepository->findNextCustomId();
        $book->setCustomId($nextCustomId);

       

        // Ajouter les catégories au livre
        $categories = $bookForm->get('categories')->getData();
        foreach ($categories as $category) {
                $book->addCategory($category);
        }

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('admin_books_management');
    }

    if ($categoryForm->isSubmitted() && $categoryForm->isValid())
    {
        $entityManager->persist($category);
        $entityManager->flush();

        return $this->redirectToRoute('admin_books_management');
    }

    return $this->render('management/bookmanagement.html.twig', [
        'books' => $books,
        'bookForm' => $bookForm->createView(),
        'categoryForm' => $categoryForm->createView(),
        ]);
    }

    #[Route('/admin/delete-book/{customId}', name: 'admin_delete_book', methods: ['GET'])]
    public function deleteBook( int $customId, BookRepository $bookRepository, EntityManagerInterface $entityManager
        ): Response {
        // Vérifier si l'utilisateur a le rôle ADMIN
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        // Rechercher le livre par customId
        $book = $bookRepository->findOneBy(['customId' => $customId]);

        if (!$book) {           
            $this->addFlash('error', 'Livre introuvable.');
            return $this->redirectToRoute('admin_books_management');
        }

        // Supprimer le livre
        $entityManager->remove($book);
        $entityManager->flush();

        // Ajouter un message de confirmation
        $this->addFlash('success', 'Le livre a été supprimé avec succès.');

        // Rediriger vers la liste des livres
        return $this->redirectToRoute('admin_books_management');
    }

    #[Route('/admin/edit-book/{id}', name: 'admin_edit_book')]
    public function editBook(
        int $id, 
        Request $request, 
        BookRepository $bookRepository, 
        EntityManagerInterface $entityManager
    ): Response {
        // Récupérer le livre via customId
        $book = $bookRepository->findOneBy(['customId' => $id]);

        if (!$book) {
            $this->addFlash('error', 'Livre introuvable.');
            return $this->redirectToRoute('admin_books_management');
        }

        // Création du formulaire
        $form = $this->createFormBuilder($book)
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('author', TextType::class, ['label' => 'Auteur'])
            ->add('summary', TextType::class, ['label' => 'Résumé', 'required' => false])
            ->add('status', EntityType::class, [
                'class' => BookStatus::class,
                'choice_label' => 'name',
                'label' => 'État du livre',
                'placeholder' => 'Choisir un état'
            ])
            ->add('categories', EntityType::class, [
                'class' => BookCategory::class,
                'choice_label' => 'categoryName',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Catégories'
            ])
            ->add('image', FileType::class, [
                'label' => 'Nouvelle Image (optionnel)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide.',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Modifier le livre'])
            ->getForm();

        // Traitement du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move($this->getParameter('book_image_directory'), $newFilename);
                $book->setImage('/uploads/book_images/' . $newFilename);
            }

            $entityManager->flush();
            $this->addFlash('success', 'Le livre a été modifié avec succès.');

            return $this->redirectToRoute('admin_books_management');
        }

        return $this->render('management/editbook.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }




    #[Route('/admin/check-loan/{customId}', name: 'admin_check_loan', methods: ['GET'])]
    public function checkLoan(
        int $customId, 
        BookRepository $bookRepository, 
        BorrowHistoryRepository $borrowHistoryRepository
    ): Response {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer le livre
        $book = $bookRepository->findOneBy(['customId' => $customId]);

        if (!$book) {
            $this->addFlash('error', 'Livre introuvable.');
            return $this->redirectToRoute('admin_books_management');
        }

        // Récupérer l'historique de l'emprunt
        $borrowHistory = $borrowHistoryRepository->createQueryBuilder('bh')
            ->join('bh.books', 'b')
            ->where('b.customId = :customId')
            ->setParameter('customId', $customId)
            ->orderBy('bh.borrowedAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$borrowHistory) {
            $this->addFlash('error', 'Aucun historique d\'emprunt trouvé pour ce livre.');
            return $this->redirectToRoute('admin_books_management');
        }

        // Vérifier si le livre a été remis à temps
        $returnedAt = $borrowHistory->getReturnedAt();
        $borrowedAt = $borrowHistory->getBorrowedAt();
        $now = new \DateTime();

        // État du retour
        $status = $returnedAt >= $now ? 'Good' : 'En retard';

        // Rendu de la vue
        return $this->render('management/checkLoan.html.twig', [
            'book' => $book,
            'borrowHistory' => $borrowHistory,
            'status' => $status,
            'user' => $borrowHistory->getUser(),
        ]);
    }




   
}