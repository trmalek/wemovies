<?php

declare(strict_types=1);

namespace App\Application\UseCases\ListGenres;

final class GenresResponse
{
    /**
     * @var array<Genre>
     */
    private $genres = [];

    private function __construct(array $genres)
    {
        $this->genres = $genres;
    }

    public static function new(array $data): self
    {
        $genres = [];
        foreach ($data as $genre) {
            $genres[] = new Genre($genre['id'], $genre['name']);
        }

        return new self($genres);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->genres as $genre) {
            $result[] = [
                'id' => $genre->getId(),
                'name' => $genre->getName(),
            ];
        }

        return $result;
    }
}
