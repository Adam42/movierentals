<?php

namespace App\Models;

use App\Enums\MovieTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * A movie can be rented by a customer or many customers.
 * Movies can have an optional tag that applies a discount or surge price.
 */
class Movie extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'base_price', 'tag'];

    protected $casts = [
        'tag' => MovieTag::class,
        'base_price' => 'float',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->withTimestamps();
    }

    /**
     * A movie can have an optional tag which can alter the movie's price.
     * */
    public function getCalculatedPrice(): float
    {
        // If a movie is priced at .01 and has a tag
        // we want to ensure the discounted price is at least
        // this minimum price.
        $minPrice = 0.01;

        if (! $this->tag) {
            return max($this->base_price, $minPrice);
        }

        $calculatedPrice = $this->base_price * $this->tag->getMultiplier();

        return max($calculatedPrice, $minPrice);
    }
}
