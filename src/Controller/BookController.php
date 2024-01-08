<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_book', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', requirements: ['id' => '\d+'], defaults: ['id' => 404], priority: 1)]
    public function show(int $id): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController::show - id : '.$id,
        ]);
    }

    #[Route('/{title}', name: 'app_book_title', methods: ['GET'])]
    public function title(BookRepository $repository, ?string $title = null): Response
    {
        $this->denyAccessUnlessGranted('book.title', $title);
        $book = $repository->findOneBy(['title' => $title]);

        return $this->redirectToRoute('app_book_show', [
            'id' => $book->getId(),
        ]);
    }
}
