<?php

namespace App\Enums;

enum MovieTag: string
{
    case TRENDING_NOW = 'trending_now';
    case UNDER_RADAR = 'under_radar';

    /**
     * Tags can have a multiplier that affects the base price.
     */
    public function getMultiplier(): float
    {
        return match ($this) {
            self::TRENDING_NOW => 1.35,  // 35% increase
            self::UNDER_RADAR => 0.50,   // 50% discount
        };
    }
}
