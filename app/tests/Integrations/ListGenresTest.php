<?php

declare(strict_types=1);

namespace App\Tests\Integrations;

use App\Adapters\Gateway\API\HttpApiMovieAdapter;
use App\Application\UseCases\ListGenres\ListGenresUseCase;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class ListGenresTest extends KernelTestCase
{
    /**
     * @test
     */
    public function shouldReturnAllGenresForMovie()
    {
        self::bootKernel();
        $container = static::getContainer();
        $listGenresUseCase = $container->get(ListGenresUseCase::class);
        $genres = $listGenresUseCase->execute();

        foreach ($genres->toArray() as $genre) {
            $this->assertArrayHasKey('id', $genre);
            $this->assertArrayHasKey('name', $genre);
            $this->assertCount(2, $genre);
        }
    }

    /**
     * @test
     */
    public function shouldNotReturnGenresForMovieIfAnExceptionIsThrown()
    {
        self::bootKernel();
        $client = new MockHttpClient([new MockResponse('error', ['http_code' => 500])]);
        $container = static::getContainer();
        $container->set('test.Symfony\Contracts\HttpClient\HttpClientInterface', $client);

        $listGenresUseCase = new ListGenresUseCase(new HttpApiMovieAdapter($client, new Logger('test')));

        $this->assertEmpty($listGenresUseCase->execute()->toArray());
    }
}
