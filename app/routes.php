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


Route::get('/', ['as' => 'mineria', 'uses' => 'DetallesController@index']);

Route::get('detalles/{exito}/{url_iniciada}', ['as' => 'mineria-iniciado', 'uses' => 'DetallesController@iniciado']);

Route::post('detalles/add', ['as' => 'add_detalles', 'uses' => 'DetallesController@store']);

Route::get('historial', ['as' => 'historial', 'uses' => 'HistorialController@index']);
