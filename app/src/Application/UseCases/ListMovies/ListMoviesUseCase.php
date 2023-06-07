<?php

declare(strict_types=1);

namespace App\Application\UseCases\ListMovies;

use App\Application\MovieDataSource;
use App\Application\UseCases\PaginatedMovieResponse;

final class ListMoviesUseCase
{
    /**
     * @var MovieDataSource
     */
    private $movieDataSource;

    public function __construct(MovieDataSource $movieDataSource)
    {
        $this->movieDataSource = $movieDataSource;
    }

    public function execute(PaginatedMovieRequest $movieRequest): PaginatedMovieResponse
    {
        return $this->movieDataSource->list($movieRequest->getGenre(), $movieRequest->getPage());
    }
}
