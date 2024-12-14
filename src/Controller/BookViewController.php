<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\BookRepository;

class BookViewController extends AbstractController
{
    #[Route('/book-view/{customId}', name: 'book_view')]
    public function bookView(int $customId, BookRepository $bookRepository): Response
    {
        // Récupérer le livre par ID
        $book = $bookRepository->findOneBy(['customId' => $customId]);

        if (!$book) {
            throw $this->createNotFoundException('Livre introuvable.');
        }

        // Rendu de la vue avec les détails du livre
        return $this->render('bookview/bookview.html.twig', [
            'book' => $book,
        ]);
    }
}