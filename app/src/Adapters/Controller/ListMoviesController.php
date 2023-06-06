<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\MovieDataSource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ListMoviesController extends AbstractController
{

    /**
     * @Route("/movies", name="movies_list")
     */
    public function __invoke(MovieDataSource $movieDataSource)
    {
        return new JsonResponse($movieDataSource->list());
    }
}
