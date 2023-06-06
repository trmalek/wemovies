<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\MovieDataSource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class RateMovieController extends AbstractController
{
    /**
     * @Route("/movies/{id}/rate", name="movies_rate", requirements={"id"="\d+"})
     */
    public function __invoke(MovieDataSource $movieDataSource, int $id)
    {
        return new JsonResponse($movieDataSource->rate($id));
    }
}
