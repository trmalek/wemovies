<?php

declare(strict_types=1);

namespace App\Application\UseCases\RateMovie;

final class MovieRateRequest
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $rate;

    public function __construct(int $id, float $rate)
    {
        $this->id = $id;
        $this->rate = $rate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}
