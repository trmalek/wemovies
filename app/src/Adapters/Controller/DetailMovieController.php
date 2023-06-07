<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\UseCases\DetailMovie\DetailMovieUseCase;
use App\Application\UseCases\DetailMovie\MovieDetailRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DetailMovieController extends AbstractController
{
    /**
     * @Route("/{id}", name="movies_item", requirements={"id"="\d+"})
     */
    public function __invoke(DetailMovieUseCase $detailMovieUseCase, int $id): Response
    {
        $movieDetailRequest = new MovieDetailRequest($id);
        $movieDetailResponse = $detailMovieUseCase->execute($movieDetailRequest);

        return new JsonResponse($movieDetailResponse->toArray());
    }
}
