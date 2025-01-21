<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * An order is created when a customer rents one or more movies.
 */
class Order extends Model
{
    protected $fillable = ['total'];

    protected $casts = [
        'total' => 'float',
    ];

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class)
            ->withTimestamps();
    }
}
