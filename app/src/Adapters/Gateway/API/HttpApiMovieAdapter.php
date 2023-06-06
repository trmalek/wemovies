<?php

declare(strict_types=1);

namespace App\Adapters\Gateway\API;


use App\Application\MovieDataSource;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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

    public function genres(): array
    {
        try {
            $response = $this->movieClient
                ->request('GET', 'genre/movie/list?language=fr')
                ->toArray();

            return array_column($response['genres'], 'name');
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }

        return [];
    }

    public function list(): array
    {
        try {
            return $this->movieClient
                ->request('GET', 'movie/top_rated?page=1')
                ->toArray()['results'];

        } catch (\Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }

        return [];
    }

    public function detail(int $movieId): array
    {
        try {
            return $this->movieClient
                ->request('GET', sprintf('movie/%d?append_to_response=videos', $movieId))
                ->toArray();
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }

        return [];
    }

    public function search(string $title): array
    {
        try {
            return $this->movieClient
                ->request('GET', sprintf('search/movie?query=%s',$title))
                ->toArray();
        } catch (\Throwable $exception) {
            $this->logger->error($exception->getTraceAsString());
        }

        return [];
    }

    public function rate(int $movieId): array
    {
        try {
            return $this->movieClient
                ->request('POST', sprintf('movie/%d/rating', $movieId))
                ->toArray();
        } catch (\Throwable $exception) {
            dd($exception);
            $this->logger->error($exception->getTraceAsString());
        }

        return [];
    }
}
