<?php


use App\Http\Controllers\PostController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});


//Route::resource('posts', PostController::class);



$router->get('/posts', 'PostController@index');
$router->post('/posts', 'PostController@store');
$router->get('/posts/{id}', 'PostController@show');
$router->post('/posts/{id}', 'PostController@update');
$router->delete('/posts/{id}', 'PostController@destroy');

Route::middleware(['custom.restrict'])->group(function () {
    Route::get('/restricted-route', [BookController::class, 'getBooks']);
  });
