<?php

namespace App\Controller;

use App\Dto\Contact;
use App\Form\ContactType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('', name: 'app_main_index')]
    public function index(MovieRepository $repository): Response
    {
        return $this->render('main/index.html.twig', [
            'movies' => $repository->findBy([], ['releasedAt' => 'DESC'], 6),
        ]);
    }

    #[Route('/contact', name: 'app_main_contact')]
    public function contact(Request $request): Response
    {
        $dto = new Contact();
        $form = $this->createForm(ContactType::class, $dto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($dto);
            $this->addFlash('info', 'Your message has been sent');

            return $this->redirectToRoute('app_main_contact');
        }

        return $this->render('main/contact.html.twig', [
            'form' => $form,
        ]);
    }
}