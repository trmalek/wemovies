<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\UseCases\ListMovies\ListMoviesUseCase;
use App\Application\UseCases\ListMovies\PaginatedMovieRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListMoviesController extends AbstractController
{

    /**
     * @Route("", name="movies_list")
     */
    public function __invoke(Request $request, ListMoviesUseCase $listMoviesUseCase): Response
    {
        $movieRequest = new PaginatedMovieRequest($request->query->get('genre'), $request->query->getInt('page', 1));
        $paginatedMovieResponse = $listMoviesUseCase->execute($movieRequest);

        return new JsonResponse($paginatedMovieResponse->toArray());
    }
}
