<?php

declare(strict_types=1);

namespace App\Tests\Integrations;

trait AssertionMovieTrait
{
    public function assertMovie(array $movie): void
    {
        $this->assertArrayHasKey('genres', $movie);
        $this->assertArrayHasKey('id', $movie);
        $this->assertArrayHasKey('language', $movie);
        $this->assertArrayHasKey('title', $movie);
        $this->assertArrayHasKey('releaseDate', $movie);
        $this->assertArrayHasKey('voteOverage', $movie);
        $this->assertArrayHasKey('voteCount', $movie);
        $this->assertArrayHasKey('videos', $movie);
        $this->assertArrayHasKey('overview', $movie);
    }
}
