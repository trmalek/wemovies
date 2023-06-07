<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\UseCases\RateMovie\MovieRateRequest;
use App\Application\UseCases\RateMovie\RateMovieUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RateMovieController extends AbstractController
{
    /**
     * @Route("/{id}/rate/{rate}", name="movies_rate", requirements={"id"="\d+"})
     */
    public function __invoke(RateMovieUseCase $rateMovieUseCase, int $id, float $rate): Response
    {
        $movieRateRequest = new MovieRateRequest($id, $rate);
        $rateMovieUseCase->execute($movieRateRequest);

        return new JsonResponse('success');
    }
}
