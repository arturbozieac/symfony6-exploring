<?php

namespace App\Provider;

use App\Consumer\OmdbApiConsumer;
use App\Entity\Movie;
use App\Enum\SearchTypeEnum;
use App\Provider\GenreProvider;
use App\Transformer\OmdbToGenreTransformer;
use App\Transformer\OmdbToMovieTransformer;

use Doctrine\ORM\EntityManagerInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

class MovieProvider
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private GenreProvider $genreProvider,
        private OmdbToMovieTransformer $movieTransformer,
        private OmdbToGenreTransformer $genreTransformer,
        private OmdbApiConsumer $apiConsumer,
    ) {
    }

    public function getMovie(SearchTypeEnum $type, string $value): Movie
    {
        if (SearchTypeEnum::Title === $type
            && $movie = $this->entityManager->getRepository(Movie::class)->omdbSearchTitle($value)
        ) {
            return $movie;
        }

        $data = $this->apiConsumer->fetch($type, $value);
        $movie = $this->movieTransformer->transform($data);

        $genres = $this->genreProvider->getFromOmdbString($data['Genre']);
        foreach ($genres as $genre) {
            $movie->addGenre($genre);
        }

        $this->entityManager->persist($movie);
        $this->entityManager->flush();

        return $movie;
    }

}