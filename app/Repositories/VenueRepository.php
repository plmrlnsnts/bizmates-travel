<?php

namespace App\Repositories;

use App\Foursquare;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class VenueRepository
{
    public function recommendations($query = []): Collection
    {
        $key = "venue-recommendations:{$query['near']}";

        return Cache::remember($key, now()->addDay(), function () use ($query) {
            $groups = Foursquare::recommendations($query);
            $photos = Foursquare::photos($groups->pluck('items.*.venue.id')->flatten(1));
            return $groups->map(fn ($group) => array_merge($group, [
                'items' => collect($group['items'])->map(fn ($item) => array_merge($item, [
                    'photos' => $photos[$item['venue']['id']] ?? [],
                ])),
            ]));
        });
    }

    public function search($query = []): Collection
    {
        $key = "venue-search:{$query['near']},${query['query']}";

        return Cache::remember($key, now()->addDay(), function () use ($query) {
            $venues = Foursquare::search($query);
            $photos = Foursquare::photos($venues->pluck('id'));
            return $venues->map(fn ($venue) => array_merge($venue, [
                'photos' => $photos[$venue['id']] ?? []
            ]));
        });
    }

    public function suggestions($query = []): Collection
    {
        return Cache::remember(
            'venue-suggestions:' . $query['near'] . ',' . $query['query'],
            now()->addDay(),
            fn () => Foursquare::suggestions($query)
        );
    }

    public function find($id): array
    {
        $key = "venue-details:{$id}";

        return Cache::remember($key, now()->addDay(), fn () => array_merge([
            'tips' => Foursquare::tips($id, ['limit' => 20]),
        ], Foursquare::find($id)));
    }
}
