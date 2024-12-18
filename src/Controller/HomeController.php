<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findRandomBooks(5);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'message' => 'Bienvenue sur votre application Symfony 7 !',
            'books' => $books,
        ]);
    }
}
