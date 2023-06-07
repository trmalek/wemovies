<?php

declare(strict_types=1);

namespace App\Application\UseCases\DetailMovie;

use App\Application\MovieDataSource;
use App\Application\UseCases\MovieResponse;

final class DetailMovieUseCase
{
    /**
     * @var MovieDataSource
     */
    private $movieDataSource;

    public function __construct(MovieDataSource $movieDataSource)
    {
        $this->movieDataSource = $movieDataSource;
    }

    public function execute(MovieDetailRequest $movieDetailRequest): MovieResponse
    {
        return $this->movieDataSource->detail($movieDetailRequest->getId());
    }
}
