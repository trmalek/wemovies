<?php

declare(strict_types=1);

namespace App\Application;

interface MovieDataSource
{
    public function genres(): array;
    public function list(): array;
    public function detail(int $movieId): array;
    public function search(string $title): array;
    public function rate(int $movieId): array;
}
