<?php

declare(strict_types=1);

namespace App\Application\UseCases\SearchMovies;

final class MoviesSearchRequest
{
    /**
     * @var string
     */
    private $title;

    public function __construct(?string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
