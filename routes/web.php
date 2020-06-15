<?php

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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => 'auth', 'prefix' => 'dash'], function () {

    Route::get('/', 'HomeController@index')->name('home');

    /**
     * Demands routes
     * 
     */
    Route::namespace('Demands')->group(function (){
        Route::prefix('demands')->name('demands.')->group(function (){
            Route::get('/', 'DemandController@index')->name('index');

            Route::get('/create', 'DemandController@create')->name('create');

            Route::post('/', 'DemandController@store')->name('store');
        });
    });

});
