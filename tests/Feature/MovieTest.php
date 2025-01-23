<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Movie;
use App\Enums\MovieTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_movies(): void
    {
        Movie::create([
            'title' => 'Test Movie',
            'base_price' => 10.00,
        ]);

        $response = $this->getJson('/api/v1/movies');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'movies');
    }

    public function test_can_create_movie(): void
    {
        $response = $this->postJson('/api/v1/movies', [
            'title' => 'New Movie',
            'base_price' => 15.99,
            'tag' => MovieTag::TRENDING_NOW->value,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'movie' => [
                    'title' => 'New Movie',
                    'base_price' => 15.99,
                    'tag' => MovieTag::TRENDING_NOW->value,
                ],
            ]);
    }

    public function test_validates_movie_price_range(): void
    {
        // Test minimum price
        $response = $this->postJson('/api/v1/movies', [
            'title' => 'Too Cheap Movie',
            'base_price' => 0.001,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('base_price');

        // Test maximum price
        $response = $this->postJson('/api/v1/movies', [
            'title' => 'Too Expensive Movie',
            'base_price' => 1000.00,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('base_price');
    }

    public function test_can_update_movie(): void
    {
        $movie = Movie::create([
            'title' => 'Original Title',
            'base_price' => 10.00,
        ]);

        $response = $this->putJson("/api/v1/movies/{$movie->id}", [
            'title' => 'Updated Title',
            'base_price' => 20.00,
            'tag' => MovieTag::UNDER_RADAR->value,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'movie' => [
                    'title' => 'Updated Title',
                    'base_price' => 20.00,
                    'tag' => MovieTag::UNDER_RADAR->value,
                ],
            ]);
    }

    public function test_can_delete_movie(): void
    {
        $movie = Movie::create([
            'title' => 'Movie to Delete',
            'base_price' => 10.00,
        ]);

        $response = $this->deleteJson("/api/v1/movies/{$movie->id}");

        $response->assertStatus(204);
        $this->assertSoftDeleted($movie);
    }

    public function test_validates_movie_tag(): void
    {
        $response = $this->postJson('/api/v1/movies', [
            'title' => 'Invalid Tag Movie',
            'base_price' => 10.00,
            'tag' => 'invalid_tag',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('tag');
    }
}
