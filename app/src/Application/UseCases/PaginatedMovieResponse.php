<?php

declare(strict_types=1);

namespace App\Application\UseCases;

final class PaginatedMovieResponse
{
    /**
     * @var int
     */
    private $currentPage;

    /**
     * @var array<MovieResponse>
     */
    private $movies;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * @var int
     */
    private $totalMovies;

    private function __construct(int $currentPage, array $movies, int $totalPages, int $totalMovies)
    {
        $this->currentPage = $currentPage;
        $this->movies = $movies;
        $this->totalPages = $totalPages;
        $this->totalMovies = $totalMovies;
    }

    public static function new(array $data): self
    {
        return new self(
            $data['currentPage'] ?? 1,
            self::addMovie($data['movies']),
            $data['totalPages'],
            $data['totalMovies']
        );
    }

    private static function addMovie(array $moviesData): array
    {
        $movies = [];
        foreach ($moviesData as $movie) {
            $movies[] = MovieResponse::new($movie);
        }

        return $movies;
    }

    public static function empty(): self
    {
        return new self(
            1,
            [],
            0,
            0
        );
    }

    public function toArray(): array
    {
        $movies = [];
        foreach ($this->movies as $movie) {
            $movies[] = $movie->toArray();
        }

        return [
            'currentPage' => $this->currentPage,
            'movies' => $movies,
            'totalPages' => $this->totalPages,
            'totalMovies' => $this->totalMovies,
        ];
    }
}
