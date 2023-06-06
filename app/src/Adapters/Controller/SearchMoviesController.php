<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\MovieDataSource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class SearchMoviesController extends AbstractController
{
    /**
     * @Route("/movies/{title}", name="movies_search")
     */
    public function __invoke(MovieDataSource $movieDataSource, string $title)
    {
        return new JsonResponse($movieDataSource->search($title));
    }
}
