<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * A movie can be rented by a customer.
 */
class Movie extends Model
{
    protected $fillable = ['title', 'base_price', 'tag'];

    protected $casts = [
        'tag' => 'string',
        'base_price' => 'float',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->withTimestamps();
    }
}
