<?php

namespace App;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class Foursquare
{
    public static function recommendations($query = []): Collection
    {
        return Http::get('https://api.foursquare.com/v2/venues/explore', array_merge([
            'client_id' => config('services.foursquare.key'),
            'client_secret' => config('services.foursquare.secret'),
            'v' => config('services.foursquare.version'),
        ], $query))->collect('response.groups');
    }

    public static function suggestions($query = []): Collection
    {
        return Http::get('https://api.foursquare.com/v2/venues/suggestcompletion', array_merge([
            'client_id' => config('services.foursquare.key'),
            'client_secret' => config('services.foursquare.secret'),
            'v' => config('services.foursquare.version'),
        ], $query))->collect('response.minivenues');
    }

    public static function search($query = []): Collection
    {
        return Http::get('https://api.foursquare.com/v2/venues/search', array_merge([
            'client_id' => config('services.foursquare.key'),
            'client_secret' => config('services.foursquare.secret'),
            'v' => config('services.foursquare.version'),
        ], $query))->collect('response.venues');
    }

    public static function photos($ids): Collection
    {
        $responses = Http::pool(fn (Pool $pool) => $ids->map(function ($id) {
            return "https://api.foursquare.com/v2/venues/${id}/photos";
        })->map(fn ($url, $i) => $pool->as($ids[$i])->get($url, [
            'client_id' => config('services.foursquare.key'),
            'client_secret' => config('services.foursquare.secret'),
            'v' => config('services.foursquare.version'),
        ])));

        return collect($responses)->map->json('response.photos');
    }

    public static function find($id): array
    {
        return Http::get("https://api.foursquare.com/v2/venues/{$id}", [
            'client_id' => config('services.foursquare.key'),
            'client_secret' => config('services.foursquare.secret'),
            'v' => config('services.foursquare.version'),
        ])->json('response.venue');
    }

    public static function tips($id, $query = []): Collection
    {
        return Http::get("https://api.foursquare.com/v2/venues/{$id}/tips", array_merge([
            'client_id' => config('services.foursquare.key'),
            'client_secret' => config('services.foursquare.secret'),
            'v' => config('services.foursquare.version'),
        ], $query))->collect('response.tips');
    }
}
