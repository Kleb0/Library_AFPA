<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\BookRepository;
use App\Repository\BorrowHistoryRepository;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class BookViewController extends AbstractController
{
    #[Route('/book-view/{customId}', name: 'book_view')]
    public function bookView(
        int $customId, 
        BookRepository $bookRepository, 
        BorrowHistoryRepository $borrowHistoryRepository, 
        EntityManagerInterface $em, 
        Request $request, 
        Connection $connection
    ): Response {
        $book = $bookRepository->findOneBy(['customId' => $customId]);
    
        if (!$book) {
            throw $this->createNotFoundException('Livre introuvable.');
        }
    
        // Récupération des commentaires
        $comments = $book->getComments();
    
        // Gestion du formulaire de commentaire
        $comment = new Comment();
        $comment->setBook($book);
    
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Votre commentaire a été ajouté.');
            return $this->redirectToRoute('book_view', ['customId' => $customId]);
        }
    
        // Rendu de la vue
        return $this->render('bookview/bookview.html.twig', [
            'book' => $book,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }
}