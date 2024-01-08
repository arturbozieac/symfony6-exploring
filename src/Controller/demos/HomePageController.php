<?php

namespace App\Controller\demos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class HomePageController extends AbstractController
{
    #[Route('/', name: 'home_page')]
    public function index(): Response
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'Home Page',
        ]);
    }

    #[Route('/contact', name: 'contact_info')]
    public function contact(): Response
    {
        return $this->render('home_page/contact.html.twig', [
            'controller_name' => 'Show contact info',
        ]);
    }
}
