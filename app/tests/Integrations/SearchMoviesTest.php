<?php

declare(strict_types=1);

namespace App\Tests\Integrations;

use App\Adapters\Gateway\API\HttpApiMovieAdapter;
use App\Application\UseCases\ListMovies\PaginatedMovieRequest;
use App\Application\UseCases\PaginatedMovieResponse;
use App\Application\UseCases\SearchMovies\MoviesSearchRequest;
use App\Application\UseCases\SearchMovies\SearchMoviesUseCase;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class SearchMoviesTest extends KernelTestCase
{
    use AssertionPaginatedMoviesTrait;

    /**
     * @test
     */
    public function shouldReturnMatchedMoviesIfTheTitleLookingForExists()
    {
        self::bootKernel();
        $container = static::getContainer();
        $searchMoviesUseCase = $container->get(SearchMoviesUseCase::class);
        $paginatedMoviesResponse = $searchMoviesUseCase->execute(new MoviesSearchRequest('john'));

        $this->assertInstanceOf(PaginatedMovieResponse::class, $paginatedMoviesResponse);
        $this->assertPaginatedMovie($paginatedMoviesResponse->toArray());
    }

    /**
     * @test
     */
    public function shouldNotReturnMoviesIfTitleLookingForDoesNotExists()
    {
        self::bootKernel();
        $client = new MockHttpClient([new MockResponse('error', ['http_code' => 404])]);
        $container = static::getContainer();
        $container->set('test.Symfony\Contracts\HttpClient\HttpClientInterface', $client);

        $searchMoviesUseCase = new SearchMoviesUseCase(new HttpApiMovieAdapter($client, new Logger('test')));

        $this->assertSame(PaginatedMovieResponse::empty()->toArray(), $searchMoviesUseCase->execute(new MoviesSearchRequest(';;;;;;;;'))->toArray());
    }

    public function getCriteriaForMovie()
    {
        return [
            yield [new PaginatedMovieRequest()],
            yield [new PaginatedMovieRequest('crime', 2)],

        ];
    }
}
