<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

class MovieController extends Controller
{
    public function index(): JsonResponse
    {
        $movies = Movie::all();

        return response()->json([
            'movies' => $movies,
        ]);
    }

    public function store(CreateMovieRequest $request): JsonResponse
    {
        $movie = Movie::create($request->validated());

        return response()->json([
            'movie' => $movie,
        ], 201);
    }

    public function show(Movie $movie): JsonResponse
    {
        return response()->json([
            'movie' => $movie,
        ]);
    }

    public function update(UpdateMovieRequest $request, Movie $movie): JsonResponse
    {
        $movie->update($request->validated());

        return response()->json([
            'movie' => $movie->fresh(),
        ]);
    }

    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();

        return response()->json([], 204);
    }
}
