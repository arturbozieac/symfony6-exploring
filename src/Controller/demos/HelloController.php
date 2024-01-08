<?php

namespace App\Controller\demos;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hello')]
class HelloController extends AbstractController
{
    #[Route('/{name}', name: 'greet_user', defaults: ['name' => 'stranger'])]
    public function index(string $name): Response
    {
        return $this->render('hello/index.html.twig', [
            'controller_name' => $name,
        ]);
    }
}
