<?php

declare(strict_types=1);

namespace App\Application\UseCases\RateMovie;

use App\Application\MovieDataSource;

final class RateMovieUseCase
{
    /**
     * @var MovieDataSource
     */
    private $movieDataSource;

    public function __construct(MovieDataSource $movieDataSource)
    {
        $this->movieDataSource = $movieDataSource;
    }

    public function execute(MovieRateRequest $movieRateRequest): void
    {
        $this->movieDataSource->rate($movieRateRequest->getId(), $movieRateRequest->getRate());
    }
}
