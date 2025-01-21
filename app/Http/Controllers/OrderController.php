<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $movies = Movie::findMany($request->movie_ids);

        $order = new Order([
            'total' => $this->calculateTotal($movies),
        ]);

        $order->save();
        $order->movies()->attach($movies);

        return response()->json([
            'order' => $order->load('movies'),
        ], 201);
    }

    private function calculateTotal(Collection $movies): float
    {
        return $movies->sum(function (Movie $movie) {
            return $movie->getCalculatedPrice();
        });
    }
}
