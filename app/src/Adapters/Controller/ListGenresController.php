<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\UseCases\ListGenres\ListGenresUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListGenresController extends AbstractController
{
    /**
     * @Route("/genres", name="movies_genres_list")
     */
    public function __invoke(ListGenresUseCase $listGenresUseCase): Response
    {
        $genresResponse = $listGenresUseCase->execute();

        return new JsonResponse($genresResponse->toArray());
    }

}
