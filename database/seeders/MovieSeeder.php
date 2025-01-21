<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Enums\MovieTag;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = [
            [
                'title' => 'The Matrix',
                'base_price' => 9.99,
                'tag' => MovieTag::TRENDING_NOW,
            ],
            [
                'title' => 'Interstellar',
                'base_price' => 12.99,
                'tag' => null,
            ],
            [
                'title' => 'The Shawshank Redemption',
                'base_price' => 14.99,
                'tag' => MovieTag::UNDER_RADAR,
            ],
            [
                'title' => 'The Town',
                'base_price' => 999.99,
                'tag' => MovieTag::TRENDING_NOW,
            ],
            [
                'title' => 'The Game',
                'base_price' => .99,
                'tag' => MovieTag::TRENDING_NOW,
            ],
            [
                'title' => 'π', // Pi, let's ensure we handle special characters
                'base_price' => 250,
                'tag' => null,
            ],
        ];

        foreach ($movies as $movie) {
            Movie::create($movie);
        }
    }
}
