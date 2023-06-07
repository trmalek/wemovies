<?php

declare(strict_types=1);

namespace App\Application\UseCases\SearchMovies;

use App\Application\MovieDataSource;
use App\Application\UseCases\PaginatedMovieResponse;

final class SearchMoviesUseCase
{
    /**
     * @var MovieDataSource
     */
    private $movieDataSource;

    public function __construct(MovieDataSource $movieDataSource)
    {
        $this->movieDataSource = $movieDataSource;
    }

    public function execute(MoviesSearchRequest $moviesSearchRequest): PaginatedMovieResponse
    {
        return $this->movieDataSource->search($moviesSearchRequest->getTitle());
    }
}
