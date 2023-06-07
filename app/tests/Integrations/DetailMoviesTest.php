<?php

declare(strict_types=1);

namespace App\Tests\Integrations;

use App\Adapters\Gateway\API\HttpApiMovieAdapter;
use App\Application\UseCases\DetailMovie\DetailMovieUseCase;
use App\Application\UseCases\DetailMovie\MovieDetailRequest;
use App\Application\UseCases\ListMovies\PaginatedMovieRequest;
use App\Application\UseCases\MovieResponse;
use App\Application\UseCases\PaginatedMovieResponse;
use App\Application\UseCases\SearchMovies\MoviesSearchRequest;
use App\Application\UseCases\SearchMovies\SearchMoviesUseCase;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetailMoviesTest extends KernelTestCase
{
    use AssertionMovieTrait;

    /**
     * @test
     */
    public function shouldReturnDetailsOfSelectedMovieIfExists()
    {
        self::bootKernel();
        $container = static::getContainer();
        $detailMovieUseCase = $container->get(DetailMovieUseCase::class);

        $movieResponse = $detailMovieUseCase->execute(new MovieDetailRequest(569094));
        $movie = $movieResponse->toArray();

        $this->assertInstanceOf(MovieResponse::class, $movieResponse);
        $this->assertMovie($movie);
    }

    /**
     * @test
     */
    public function shouldNotReturnMovieIfItDoesNotExists()
    {
        self::bootKernel();
        $client = new MockHttpClient([new MockResponse('error', ['http_code' => 404])]);
        $container = static::getContainer();
        $container->set('test.Symfony\Contracts\HttpClient\HttpClientInterface', $client);
        $this->expectException(NotFoundHttpException::class);

        $searchMoviesUseCase = new DetailMovieUseCase(new HttpApiMovieAdapter($client, new Logger('test')));
        $searchMoviesUseCase->execute(new MovieDetailRequest(4444));
    }

    public function getCriteriaForMovie()
    {
        return [
            yield [new PaginatedMovieRequest()],
            yield [new PaginatedMovieRequest('crime', 2)],

        ];
    }
}
