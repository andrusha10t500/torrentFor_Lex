<?php

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

Route::get('/', function () {
    return view('main');
});

Route::post('/signup', [
    'uses' => 'UserController@signup',
    'as' => 'signup'
]);

Route::get('/routeTorrentController/{name}',  [
   'uses' => 'torrentController@create',
   'as' =>  'create',
   'middleware' => 'auth'
]);

Route::get('/routeTorrentController', [
   'uses' => 'torrentController@showtorrents',
   'as' => 'showtorrents'
]);

Route::post('/sendtorrent', [
   'uses' => 'torrentController@store',
   'as' => 'sendtorrent'
]);
