<?php

namespace App;

use Illuminate\Support\Facades\Http;

class OpenWeather
{
    public static function weather($query = []): array
    {
        return Http::get('https://api.openweathermap.org/data/2.5/weather', array_merge([
            'appid' => config('services.openweather.key'),
        ], $query))->json();
    }
}
