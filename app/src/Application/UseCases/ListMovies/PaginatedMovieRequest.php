<?php

declare(strict_types=1);

namespace App\Application\UseCases\ListMovies;

final class PaginatedMovieRequest
{
    /**
     * @var string|null
     */
    private $genre;

    /**
     * @var int
     */
    private $page;

    public function __construct(?string $genre = null, int $page = 1)
    {
        $this->genre = $genre;
        $this->page = $page;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
