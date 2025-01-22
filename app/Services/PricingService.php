<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Support\Collection;

class PricingService
{
    public function calculateTotal(Collection $movies): float
    {
        return $movies->sum(function (Movie $movie) {
            return $movie->getCalculatedPrice();
        });
    }
}
