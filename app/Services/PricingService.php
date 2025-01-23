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
        $total = $movies->sum(function (Movie $movie) {
            return $movie->getCalculatedPrice();
        });

        return round($total, 2);
    }
}
