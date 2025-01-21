<?php

namespace App\Models;

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
        'tag' => 'string',
        'base_price' => 'float',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->withTimestamps();
    }
}
