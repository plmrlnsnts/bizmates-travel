<?php

namespace App\Repositories;

use App\OpenWeather;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CityRepository
{
    /**
     * Get the current weather of a specific location.
     *
     * @param array $query
     * @return array
     */
    public function weather($query = []): array
    {
        return Cache::remember(
            'city-weather-'.$query['q'],
            now()->addHour(),
            fn () => OpenWeather::weather($query),
        );
    }
}
