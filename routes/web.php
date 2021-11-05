<?php

use App\Repositories\CityRepository;
use App\Repositories\VenueRepository;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', fn () => inertia('Home', [
    'weather' => (new CityRepository)->weather([
        'q' => request('near', 'Kyoto'),
        'units' => 'metric',
    ]),
    'recommendations' => (new VenueRepository)->recommendations([
        'near' => request('near', 'Kyoto'),
        'limit' => 6,
    ]),
]))->name('home');

Route::get('/venues/autocomplete', fn () => [
    'suggestions' => (new VenueRepository)->suggestions([
        'near' => request('near', 'Kyoto'),
        'query' => request('query'),
        'limit' => 5,
    ]),
])->name('venues.autocomplete');

Route::get('/venues/search', fn () => inertia('Venues/Search', [
    'venues' => (new VenueRepository)->search([
        'near' => request('near', 'Kyoto'),
        'query' => request('query'),
        'limit' => 20,
    ]),
]))->name('venues.search');

Route::get('/venues/{venue}', fn ($venue) => inertia('Venues/Show', [
    'venue' => (new VenueRepository)->find($venue),
]))->name('venues.show');
