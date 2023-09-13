<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/api/movies/{id<\d+>}', methods: ['GET'], name: 'api_get_movie')]
    public function getMovie(int $id): Response
    {
        $movie = [
            'id' => $id,
            'name' => 'Psí ostrov',
            'genre' => 'komedie'
        ];

        return $this->json($movie);
    }
}