<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', ['as' => 'mineria', 'uses' => 'HistorialController@index']);

Route::get('/{url_iniciada}', ['as' => 'mineria-iniciado', 'uses' => 'HistorialController@iniciado']);

Route::post('historial/add', ['as' => 'add_historial', 'uses' => 'HistorialController@store']);

Route::get('/prueba/crawler', ['as' => 'crawler', 'uses' => 'HistorialController@crawler']);