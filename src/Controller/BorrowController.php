<?php

namespace App\Controller;

use App\Entity\BorrowHistory;
use App\Repository\BorrowHistoryRepository;
use App\Repository\BookRepository;
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
    public function borrowBook( int $customId, BookRepository $bookRepository, BorrowHistoryRepository $borrowHistoryRepository, EntityManagerInterface $entityManager): 
    Response {
        $user = $this->getUser();

        if (!$user || !$user->getSubscriptions()->count()) {
            $this->addFlash('error', 'Vous devez être connecté avec un abonnement actif pour emprunter un livre.');
            return $this->redirectToRoute('book_view', ['customId' => $customId]);
        }

        $book = $bookRepository->findOneBy([
            'customId' => $customId
        ]);

        // //ajouter la date de retou  

        // Créer une nouvelle entrée BorrowHistory
        $borrowHistory = new BorrowHistory();
        $borrowHistory->setUserId($user->getId());
        $borrowHistory->setBorrowedAt(new \DateTime());
        $borrowHistory->setReturnedAt(new \DateTime('+6 days'));
        $borrowHistory->addBook($book);

        if (!$user || !$user->getSubscriptions()->count()) {
            $this->addFlash('error', 'Vous devez être connecté avec un abonnement actif pour emprunter un livre.');
            return $this->redirectToRoute('book_view', ['customId' => $customId]);
        }


        // if (!$book || !$book->isAvailable()) {
        //     $this->addFlash(
        //         'error',
        //         'Ce livre n\'est pas disponible pour emprunt. La date de retour est le : ' . $borrowHistory->getReturnedAt()->format('d/m/Y')
        //     );
        //     return $this->render('bookview/bookview.html.twig', [
        //         'book' => $book,
        //         'borrowHistory' => $borrowHistory,
        //         'returnedAt' => $borrowHistory->getReturnedAt(),
        //     ]);
        // }
    

        // Marquer le livre comme indisponible
        $book->setAvailability(false);

        // Sauvegarder les changements
        $entityManager->persist($borrowHistory);
        $entityManager->flush();

        $this->addFlash('success', 'Le livre a été emprunté avec succès.');

        return $this->render('bookview/bookview.html.twig', [
            'book' => $book,
            'borrowHistory' => $borrowHistory,
            'returnedAt' => $borrowHistory->getReturnedAt(),
        ]);
    }

}
