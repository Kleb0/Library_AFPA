<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(BookRepository $bookRepository): Response
    {
        // Récupérer 5 livres au hasard via la méthode `findRandomBooks` du repository
        $books = $bookRepository->findRandomBooks(5);

        // dd($books);

        // return $this->render('catalogue/index.html.twig', [
        //     'books' => $books,
        // ]);
        return $this->render('home/index.html.twig', [
            'books' => $books, // On transmet `books` pour que le template puisse l'utiliser
            'message' => 'Découvrez notre sélection de livres !',
        ]);

    }
}
