<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\UseCases\SearchMovies\MoviesSearchRequest;
use App\Application\UseCases\SearchMovies\SearchMoviesUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchMoviesController extends AbstractController
{
    /**
     * @Route("/{title}", name="movies_search")
     */
    public function __invoke(SearchMoviesUseCase $searchMoviesUseCase, string $title): Response
    {
        $moviesSearchRequest = new MoviesSearchRequest($title);
        $paginatedMovieResponse = $searchMoviesUseCase->execute($moviesSearchRequest);

        return new JsonResponse($paginatedMovieResponse->toArray());
    }
}
