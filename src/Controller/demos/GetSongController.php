<?php

namespace App\Controller\demos;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

#[AsController]
class GetSongController
{
    public function __construct(private readonly Environment $twig)
    {
    }

    #[Route('/song', name: 'get_song')]
    public function __invoke() : Response
    {
        return new Response($this->twig->render('hello/index.html.twig', [
            'controller_name' => 'See the song',
        ]));
    }

}