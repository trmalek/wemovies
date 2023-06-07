<?php

declare(strict_types=1);

namespace App\Adapters\Gateway\API;

use App\Application\MovieDataSource;
use App\Application\UseCases\ListGenres\GenresResponse;
use App\Application\UseCases\MovieResponse;
use App\Application\UseCases\PaginatedMovieResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final class HttpApiMovieAdapter implements MovieDataSource
{
    /**
     * @var HttpClientInterface $movieClient
     */
    private $movieClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(HttpClientInterface $movieClient, LoggerInterface $logger)
    {
        $this->movieClient = $movieClient;
        $this->logger = $logger;
    }

    public function genres(): GenresResponse
    {
        try {
            $genres = $this->movieClient
                ->request('GET', 'genre/movie/list?language=fr')
                ->toArray()['genres'];

            return GenresResponse::new($genres);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }

        return GenresResponse::empty();
    }

    public function list(?string $genre = null, int $page = 1): PaginatedMovieResponse
    {
        try {
            $genreCriteria = $genre ? sprintf('&with_genres=%s', $genre) : '';

            $movies = $this->movieClient
                ->request(
                    'GET',
                    sprintf(
                        'discover/movie?page=%d&include_video=true&sort_by=vote_average.desc%s',
                        $page,
                        $genreCriteria
                    )
                )
                ->toArray();

            return PaginatedMovieResponse::new(
                [
                    'currentPage' => $movies['page'],
                    'movies' => $this->mapMovies($movies['results']),
                    'totalPages' => $movies['total_pages'],
                    'totalMovies' => $movies['total_results'],
                ]
            );
        } catch (Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }

        return PaginatedMovieResponse::empty();
    }

    private function mapMovies($results1): array
    {
        $results = [];

        foreach ($results1 as $movie) {
            $results[] = [
                'genres' => $movie['genre_ids'],
                'id' => $movie['id'],
                'language' => $movie['original_language'],
                'title' => $movie['original_title'],
                'releaseDate' => $movie['release_date'],
                'voteOverage' => $movie['vote_average'],
                'voteCount' => $movie['vote_count'],
                'videos' => $movie['videos'] ?? [],
                'overview' => $movie['overview']
            ];
        }
        return $results;
    }

    public function detail(int $movieId): MovieResponse
    {
        try {
            $movieData = $this->movieClient
                ->request('GET', sprintf('movie/%d?append_to_response=videos', $movieId))
                ->toArray();

            return MovieResponse::new(
                [
                    'genres' => $movieData['genres'],
                    'id' => $movieData['id'],
                    'language' => $movieData['original_language'],
                    'title' => $movieData['original_title'],
                    'releaseDate' => $movieData['release_date'],
                    'voteOverage' => $movieData['vote_average'],
                    'voteCount' => $movieData['vote_count'],
                    'videos' => $movieData['videos'],
                    'overview' => $movieData['overview']
                ]
            );
        } catch (Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }

        throw new NotFoundHttpException();
    }

    public function search(string $title): PaginatedMovieResponse
    {
        try {
            $movies = $this->movieClient
                ->request('GET', sprintf('search/movie?query=%s', $title))
                ->toArray();

            return PaginatedMovieResponse::new(
                [
                    'currentPage' => $movies['page'],
                    'movies' => $this->mapMovies($movies['results']),
                    'totalPages' => $movies['total_pages'],
                    'totalMovies' => $movies['total_results'],

                ]
            );

        } catch (Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }

        return PaginatedMovieResponse::empty();
    }

    public function rate(int $movieId, float $rate): void
    {
        try {
            $this->movieClient
                ->request('POST', sprintf('movie/%d/rating', $movieId), ['body' => $rate])
                ->toArray();
        } catch (Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }
    }
}
