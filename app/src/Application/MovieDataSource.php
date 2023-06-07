<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\UseCases\ListGenres\GenresResponse;
use App\Application\UseCases\MovieResponse;
use App\Application\UseCases\PaginatedMovieResponse;

interface MovieDataSource
{
    public function genres(): GenresResponse;

    public function list(?string $genre = null, int $page): PaginatedMovieResponse;

    public function detail(int $movieId): MovieResponse;

    public function search(string $title): PaginatedMovieResponse;

    public function rate(int $movieId, float $rate): void;
}
