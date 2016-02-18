<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('login', 'Auth\AuthController@getLogin')->name('login.formulario');
Route::post('login', 'Auth\AuthController@postLogin')->name('login.submeter_formulario');
Route::get('logout', 'Auth\AuthController@getLogout')->name('login.deslogar');

Route::get("chef/detalhes/{id}", "PageController@getChefDetalhes")->name("chef.detalhes");