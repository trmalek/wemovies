<?php

declare(strict_types=1);

namespace App\Adapters\Controller;

use App\Application\MovieDataSource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DetailMovieController extends AbstractController
{
    /**
     * @Route("/movies/{id}", name="movies_item", requirements={"id"="\d+"})
     */
    public function __invoke(MovieDataSource $movieDataSource, int $id)
    {
        return new JsonResponse($movieDataSource->detail($id));
    }
}
