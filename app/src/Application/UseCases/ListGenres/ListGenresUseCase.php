<?php

declare(strict_types=1);

namespace App\Application\UseCases\ListGenres;

use App\Application\MovieDataSource;

final class ListGenresUseCase
{
    /**
     * @var MovieDataSource
     */
    private $movieDataSource;

    public function __construct(MovieDataSource $movieDataSource)
    {
        $this->movieDataSource = $movieDataSource;
    }

    public function execute(): GenresResponse
    {
        return $this->movieDataSource->genres();
    }
}
