<?php

use App\Http\Controllers\BasicController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Laravel\Octane\Facades\Octane;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Start with Laravel Octane
|--------------------------------------------------------------------------
|
| Install Octane
| $ composer require laravel/octane
| $ php artisan octane:install
|
| The command octane:install will create config/octane.php
| For checking if Swoole extension is installed and activated:
| $ php -m | grep swoole
| In .env file check if OCTANE_SERVER=swoole
|
| try:
| $ php artisan serve
| $ php artisan octane:start
| $ php artisan octane:start --max-requests=10
*/

/*
|--------------------------------------------------------------------------
| Managing static properties
|--------------------------------------------------------------------------
|
| Showing the side effects with static properties
|
*/
Route::get('/add-item', [BasicController::class, 'addItem'])->name('static-props');

/*
|--------------------------------------------------------------------------
| Optimizing routes
|--------------------------------------------------------------------------
|
| Using Octane::route()
|
*/
Octane::route('GET', '/route-octane', function () {
    return new Response('Ciao LaravelDay, ecco a voi "Octane Route".');
});
Route::get('/route-get',
function () {
    return new Response('Ciao LaravelDay, questa é una Laravel Route. Prova <a href="/route-octane">Octane Route</a>');
}
)->name('route-get');

/*
|--------------------------------------------------------------------------
| Parallel functions
|--------------------------------------------------------------------------
|
| Using Octane::concurrently()
|
*/
Route::get('/serial-task', function () {
    [$result1, $result2] = [
        function () {
            sleep(2);

            return random_int(1, 10);
        },
        function () {
            sleep(2);

            return random_int(1, 10);
        },
    ];

    return new Response('Ciao LaravelDay, (task serializzati)'.$result1().' - '.$result2());
})->name('serial-task');

Route::get('/parallel-task', function () {
    [$result1, $result2] = Octane::concurrently([
        function () {
            sleep(2);

            return random_int(1, 10);
        },
        function () {
            sleep(2);

            return random_int(1, 10);
        },
    ]);

    return new Response('Ciao LaravelDay (task in parallelo), '.$result1.' - '.$result2);
})->name('parallel-task');

/*
|--------------------------------------------------------------------------
| interval execution via tick
|--------------------------------------------------------------------------
|
| See AppServiceProvider()
|
*/

/*
|--------------------------------------------------------------------------
| Cache
|--------------------------------------------------------------------------
|
| Using Cache::store('octane') for getting instance
| put() to set the value in cache
| get() to get the value from cache
|
*/
Route::get('/set-random-number', function () {
    $number = random_int(1, 6);
    Cache::store('octane')
        ->put(
            'last-random-number',
            $number
        );

    return $number;
})->name('set-cache');
Route::get('/get-random-number', function () {
    $number = Cache::store('octane')->get('last-random-number', 0);

    return $number;
})->name('get-cache');

/*
|--------------------------------------------------------------------------
| Cache Only strategy
|--------------------------------------------------------------------------
|
| The cached is filled in AppServiceProvider using tick() method
| Here we retrieve the value from cache.
| Strong assumption, the value is stored in the cache.
|
*/
Route::get('/get-random-number-chache-only', function () {
    $number = Cache::store('octane')
        ->get(
        'last-random-number',
            0
        );

    return $number;
})->name('get-cache-only');

/*
|--------------------------------------------------------------------------
| Swoole Table
|--------------------------------------------------------------------------
|
| - Create values in table
| - Get a value in table
|
*/
Route::get('/create-table', function () {
    $faker = Faker\Factory::create();

    $table = Octane::table('example');
    for ($i = 0; $i < 500; $i++) {
        $table->set($i,
            [
                'name' => $faker->firstName(),
                'votes' => random_int(1, 1000),
            ]);
    }

    return "Created $i rows";
})->name('create-table');
Route::get('/get-table', function () {
    $table = Octane::table('example');

    return $table->get(random_int(1, 500));
})->name('get-table');

/*
|--------------------------------------------------------------------------
| Using Swoole methods
|--------------------------------------------------------------------------
|
| Using Swoole with Laravel Octane,
| you can access to Swoole methods, for example stats()
|
*/
Route::get('/metrics', function () {
    $server = App::make(Swoole\Http\Server::class);

    return $server->stats();
})->name('metrics');

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/welcome', function () {
    return view('welcome');
});
