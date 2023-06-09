<?php

declare(strict_types=1);

namespace App\Application\UseCases\DetailMovie;

final class MovieDetailRequest
{
    /**
     * @var int
     */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
