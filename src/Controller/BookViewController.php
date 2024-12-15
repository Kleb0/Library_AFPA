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
        $comment->setUser($this->getUser()); // Associe l'utilisateur connecté
    
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

    #[Route('/comment/delete/{id}', name: 'comment_delete', methods: ['POST'])]
    public function deleteComment(
        int $id,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $comment = $em->getRepository(Comment::class)->find($id);

        if (!$comment) {
            throw $this->createNotFoundException('Commentaire introuvable.');
        }

        // Vérifie si l'utilisateur a le rôle admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Vous n\'avez pas les droits pour effectuer cette action.');
            return $this->redirectToRoute('book_view', ['customId' => $comment->getBook()->getCustomId()]);
        }

        if ($this->isCsrfTokenValid('delete_comment' . $comment->getId(), $request->request->get('_token'))) {
            $em->remove($comment);
            $em->flush();
            $this->addFlash('success', 'Commentaire supprimé avec succès.');
        }

        return $this->redirectToRoute('book_view', ['customId' => $comment->getBook()->getCustomId()]);
    }

    
}