<?php

declare(strict_types=1);

namespace App\Tests\Integrations;

trait AssertionPaginatedMoviesTrait
{
    use AssertionMovieTrait;

    public function assertPaginatedMovie(array $paginatedMovies): void
    {
        $this->assertArrayHasKey('currentPage', $paginatedMovies);
        $this->assertArrayHasKey('movies', $paginatedMovies);
        $this->assertArrayHasKey('totalPages', $paginatedMovies);
        $this->assertArrayHasKey('totalMovies', $paginatedMovies);

        foreach ($paginatedMovies['movies'] as $movie) {
            $this->assertMovie($movie);
        }
    }
}
