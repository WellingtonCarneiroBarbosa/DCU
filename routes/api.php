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
    Route::prefix('tickets')->group(function (){
        Route::get('/', 'TicketController@index')->name('tickets.index');

        Route::get('/{id}', 'TicketController@show')->name('tickets.show');

        Route::post('/', 'TicketController@store')->name('tickets.store');
    });
});
