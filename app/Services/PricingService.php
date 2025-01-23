<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Support\Collection;

class PricingService
{
    /**
     * Returns the total price of a collection of movies using calculated dynamic prices.
     */
    public function calculateTotal(Collection $movies): float
    {
        return $movies->sum(function (Movie $movie) {
            return $movie->getCalculatedPrice();
        });
    }
}
