<?php

declare(strict_types=1);

namespace App\Tests\Integrations;

use App\Adapters\Gateway\API\HttpApiMovieAdapter;
use App\Application\UseCases\ListMovies\ListMoviesUseCase;
use App\Application\UseCases\ListMovies\PaginatedMovieRequest;
use App\Application\UseCases\PaginatedMovieResponse;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class ListMoviesTest extends KernelTestCase
{
    use AssertionPaginatedMoviesTrait;

    /**
     * @test
     * @dataProvider getCriteriaForMovie
     */
    public function shouldReturnAllSelectedMovies(PaginatedMovieRequest $listMoviesRequest)
    {
        self::bootKernel();
        $container = static::getContainer();
        $listMoviesUseCase = $container->get(ListMoviesUseCase::class);
        $paginatedMoviesResponse = $listMoviesUseCase->execute($listMoviesRequest);
        $this->assertInstanceOf(PaginatedMovieResponse::class, $paginatedMoviesResponse);
        $this->assertPaginatedMovie($paginatedMoviesResponse->toArray());
    }

    /**
     * @test
     */
    public function shouldNotReturnNoMoviesIfAnExceptionIsThrown()
    {
        self::bootKernel();
        $client = new MockHttpClient([new MockResponse('error', ['http_code' => 500])]);
        $container = static::getContainer();
        $container->set('test.Symfony\Contracts\HttpClient\HttpClientInterface', $client);

        $listGenresUseCase = new ListMoviesUseCase(new HttpApiMovieAdapter($client, new Logger('test')));

        $this->assertSame(PaginatedMovieResponse::empty()->toArray(), $listGenresUseCase->execute(new PaginatedMovieRequest())->toArray());
    }

    public function getCriteriaForMovie()
    {
        return [
            yield [new PaginatedMovieRequest()],
            yield [new PaginatedMovieRequest('crime', 2)],

        ];
    }
}
