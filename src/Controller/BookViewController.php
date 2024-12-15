<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BookRepository;
use App\Repository\BorrowHistoryRepository;
use Doctrine\DBAL\Connection;

class BookViewController extends AbstractController
{
    #[Route('/book-view/{customId}', name: 'book_view')]
    public function bookView(int $customId, BookRepository $bookRepository, BorrowHistoryRepository $borrowHistoryRepository, Connection $connection): Response
    {
        // Récupérer le livre par ID
        $book = $bookRepository->findOneBy(['customId' => $customId]);

        if (!$book) {
            throw $this->createNotFoundException('Livre introuvable.');
        }

        $sql = '
        SELECT bh.* 
        FROM borrow_history bh
        INNER JOIN borrow_history_book bhb ON bh.id = bhb.borrow_history_id
        WHERE bhb.book_id = :bookId
        ';

        $borrowHistory = $connection->fetchAssociative($sql, ['bookId' => $book->getCustomId()]);

        // Rendu de la vue avec les détails du livre
        return $this->render('bookview/bookview.html.twig', [
            'book' => $book,
            'borrowHistory' => $borrowHistory,
        ]);
    }
}