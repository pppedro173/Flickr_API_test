<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlickrController;


/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix'=>'api/v3'], function() use($router){
    $router->get('/flickr', 'FlickrController@showmultipleemp');                                 // Default values
    $router->get('/flickr/{query}', 'FlickrController@showmultiplet');                        // With text
    $router->get('/flickr/{query}/{perpage}', 'FlickrController@showmultipletpp');               // With text and perpage
    $router->get('/flickr/{query}/{perpage}/{page}', 'FlickrController@showmultipletppp');       // With text, perpage and page
    $router->get('/flick/rand', 'FlickrController@showrand');                                      // 1 random image
});

