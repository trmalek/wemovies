<?php

declare(strict_types=1);

namespace App\Application\UseCases;

final class MovieResponse
{
    /**
     * @var array<int>
     */
    private $genres;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $releaseDate;

    /**
     * @var float
     */
    private $voteAverage;

    /**
     * @var int
     */
    private $voteCount;

    /**
     * @var array
     */
    private $videos;

    /**
     * @var string
     */
    private $overview;

    private function __construct(
        array $genres,
        int $id,
        string $language,
        string $title,
        string $releaseDate,
        float $voteAverage,
        int $voteCount,
        array $videos,
        string $overview
    )
    {
        $this->genres = $genres;
        $this->id = $id;
        $this->language = $language;
        $this->title = $title;
        $this->releaseDate = $releaseDate;
        $this->voteAverage = $voteAverage;
        $this->voteCount = $voteCount;
        $this->videos = $videos;
        $this->overview = $overview;
    }

    public static function new(array $data): self
    {
        return new self(
            $data['genres'] ?? [],
            $data['id'],
            $data['language'],
            $data['title'],
            $data['releaseDate'],
            $data['voteOverage'],
            $data['voteCount'],
            $data['videos'],
            $data['overview']
        );
    }

    public function toArray(): array
    {
        return [
            'genres' => $this->genres,
            'id' => $this->id,
            'language' => $this->language,
            'title' => $this->title,
            'releaseDate' => $this->releaseDate,
            'voteOverage' => $this->voteAverage,
            'voteCount' => $this->voteCount,
            'videos' => $this->videos,
            'overview' => $this->overview
        ];
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getVoteAverage(): float
    {
        return $this->voteAverage;
    }

    public function getVoteCount(): int
    {
        return $this->voteCount;
    }

    public function getVideos(): array
    {
        return $this->videos;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }
}
