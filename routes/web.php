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

Route::get('/create',  [
   'uses' => 'TorrentController@create',
   'as' =>  'create'
])->middleware('auth');

Route::get('/routeTorrentController', [
   'uses' => 'TorrentController@showtorrents',
   'as' => 'showtorrents'
]);

Route::post('/sendtorrent', [
   'uses' => 'TorrentController@store',
   'as' => 'sendtorrent'
]);

Route::post('/deleteTorrent',[
   'uses' => 'TorrentController@deleteTorrent',
   'as' => 'deleteTorrent'
]);
