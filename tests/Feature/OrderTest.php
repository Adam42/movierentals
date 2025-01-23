<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Movie;
use App\Enums\MovieTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_order_with_single_movie(): void
    {
        $movie = Movie::create([
            'title' => 'Test Movie',
            'base_price' => 10.00,
        ]);

        $response = $this->postJson('/api/v1/orders', [
            'movie_ids' => [$movie->id],
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'order' => [
                    'total' => 10.00,
                ],
            ]);
    }

    public function test_can_create_order_with_trending_movie(): void
    {
        $movie = Movie::create([
            'title' => 'Trending Movie',
            'base_price' => 10.00,
            'tag' => MovieTag::TRENDING_NOW,
        ]);

        $response = $this->postJson('/api/v1/orders', [
            'movie_ids' => [$movie->id],
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'order' => [
                    'total' => 13.50, // 10.00 * 1.35
                ],
            ]);
    }

    public function test_can_create_order_with_under_radar_movie(): void
    {
        $movie = Movie::create([
            'title' => 'Under Radar Movie',
            'base_price' => 10.00,
            'tag' => MovieTag::UNDER_RADAR,
        ]);

        $response = $this->postJson('/api/v1/orders', [
            'movie_ids' => [$movie->id],
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'order' => [
                    'total' => 5.00, // 10.00 * 0.50
                ],
            ]);
    }

    public function test_can_create_order_with_multiple_movies(): void
    {
        // Create movies and collect them into a Collection
        $movies = collect([
            Movie::create([
                'title' => 'Regular Movie',
                'base_price' => 10.00,
            ]),
            Movie::create([
                'title' => 'Trending Movie',
                'base_price' => 10.00,
                'tag' => MovieTag::TRENDING_NOW,
            ]),
            Movie::create([
                'title' => 'Under Radar Movie',
                'base_price' => 10.00,
                'tag' => MovieTag::UNDER_RADAR,
            ]),
        ]);

        $response = $this->postJson('/api/v1/orders', [
            'movie_ids' => $movies->pluck('id')->toArray(),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'order' => [
                    'total' => 28.50, // 10.00 + (10.00 * 1.35) + (10.00 * 0.50)
                ],
            ]);
    }

    public function test_cannot_create_order_with_invalid_movie_id(): void
    {
        $response = $this->postJson('/api/v1/orders', [
            'movie_ids' => [999],
        ]);

        $response->assertStatus(422);
    }

    public function test_handles_edge_case_with_minimum_price(): void
    {
        $movie = Movie::create([
            'title' => 'Minimum Price Movie',
            'base_price' => 0.01,
            'tag' => MovieTag::UNDER_RADAR,
        ]);

        $response = $this->postJson('/api/v1/orders', [
            'movie_ids' => [$movie->id],
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'order' => [
                    'total' => 0.01, // Should round to 0.01, not 0.005
                ],
            ]);
    }

    public function test_handles_edge_case_with_maximum_price(): void
    {
        $movie = Movie::create([
            'title' => 'Maximum Price Movie',
            'base_price' => 999.99,
            'tag' => MovieTag::TRENDING_NOW,
        ]);

        $response = $this->postJson('/api/v1/orders', [
            'movie_ids' => [$movie->id],
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'order' => [
                    'total' => 1349.99, // 999.99 * 1.35
                ],
            ]);
    }
}
