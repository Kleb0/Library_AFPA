<?php

namespace App\Controller;

use App\Entity\BorrowHistory;
use App\Repository\BorrowHistoryRepository;
use App\Repository\BookRepository;
use App\Entity\Comment;
use App\Form\CommentType; 
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class BorrowController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function account(BorrowHistoryRepository $borrowHistoryRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Récupérer l'historique des emprunts pour l'utilisateur actuel
        $borrowHistory = $borrowHistoryRepository->findBy(['userId' => $user->getId()]);

        return $this->render('account/account.html.twig', [
            'borrowHistory' => $borrowHistory,
        ]);
    }

    #[Route('/book-view/{customId}/borrow', name: 'book_borrow', methods: ['POST'])]
    public function borrowBook(
        int $customId, 
        BookRepository $bookRepository, 
        BorrowHistoryRepository $borrowHistoryRepository, 
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $user = $this->getUser();

        if (!$user || !$user->getSubscriptions()->count()) {
            $this->addFlash('error', 'Vous devez être connecté avec un abonnement actif pour emprunter un livre.');
            return $this->redirectToRoute('book_view', ['customId' => $customId]);
        }

        $book = $bookRepository->findOneBy(['customId' => $customId]);

        // Créer une nouvelle entrée BorrowHistory
        $borrowHistory = new BorrowHistory();
        $borrowHistory->setUser($user);
        $borrowHistory->setUserId($user->getId());
        $borrowHistory->setBorrowedAt(new \DateTime());
        $borrowHistory->setReturnedAt(new \DateTime('+6 days'));
        $borrowHistory->addBook($book);

        // Marquer le livre comme indisponible
        $book->setAvailability(false);

        // Sauvegarder les changements
        $entityManager->persist($borrowHistory);
        $entityManager->flush();

        $this->addFlash('success', 'Le livre a été emprunté avec succès.');
        $borrowHistory = $borrowHistoryRepository->findOneBy(['user' => $user, 'returnedAt' => null]);

        //on passe les commentaires, et le formulaire à la vue, qui récupèrera les données liées
        $comments = $book->getComments();

        $comment = new Comment();
        $comment->setBook($book);
        $comment->setUser($user);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        return $this->render('bookview/bookview.html.twig', [
            'book' => $book,  
            'comments' => $comments,             
            'borrowHistory' => $borrowHistory,
            'form' => $form->createView(),
            
        ]);
    }

    #[Route('/loan-management', name: 'loan_management')]
    public function loanManagement(BorrowHistoryRepository $borrowHistoryRepository, EntityManagerInterface $entityManager): Response
    {
        $borrowHistories = $borrowHistoryRepository->createQueryBuilder('b')
            ->where('b.returnedAt IS NULL') // Cas où le retour n'a pas été enregistré
            ->orWhere('b.returnedAt > :now') // Si le retour est prévu dans le futur
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getResult();

        return $this->render('management/loanManagement.html.twig', [
            'borrowHistories' => $borrowHistories,
        ]);
    }

    #[Route('/loan-management/return/{id}', name: 'return_book', methods: ['GET', 'POST'])]
    public function returnBook(int $id, BorrowHistoryRepository $borrowHistoryRepository, EntityManagerInterface $entityManager): RedirectResponse
    {
        $borrowHistory = $borrowHistoryRepository->find($id);
    
        if (!$borrowHistory) {
            $this->addFlash('error', 'Historique de prêt introuvable.');
            return $this->redirectToRoute('loan_management');
        }
    
        // Marquer le livre comme disponible
        foreach ($borrowHistory->getBooks() as $book) {
            $book->setAvailability(true);
        }

        
        $entityManager->remove($borrowHistory);    
        $entityManager->flush();
    
        $this->addFlash('success', 'Le livre a été restitué avec succès.');
    
        return $this->redirectToRoute('loan_management');
    }

    #[Route('/loan-management/confirm-return/{id}', name: 'confirm_return_book', methods: ['GET'])]
    public function confirmReturn(int $id, BorrowHistoryRepository $borrowHistoryRepository): Response
    {
        $borrowHistory = $borrowHistoryRepository->find($id);

        if (!$borrowHistory) {
            $this->addFlash('error', 'Historique de prêt introuvable.');
            return $this->redirectToRoute('loan_management');
        }

        return $this->render('management/confirm_return.html.twig', [
            'borrowHistory' => $borrowHistory,
        ]);
    }
    


}
