<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->name('api.')->group(function (){
    /**
     * Tickets routes
     * 
     */
    Route::prefix('tickets')->name('tickets.')->group(function (){
        Route::get('/', 'TicketController@index')->name('index');

        Route::get('/{id}', 'TicketController@show')->name('show');

        Route::post('/', 'TicketController@store')->middleware('apiToken')->name('store');
    });

    /**
     * Demands routes
     * 
     */
    Route::prefix('demands')->name('demands.')->group(function (){
        Route::get('/', 'DemandController@index')->name('index');
    });
});
