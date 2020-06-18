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
     * JWT Protected Routes
     * 
     */
    Route::group(['middleware' => ['jwtToken']], function () {
        /**
         * Tickets routes
         * 
         */
        Route::prefix('tickets')->name('tickets.')->group(function (){
            Route::get('/', 'TicketController@index')->name('index');

            Route::get('/{id}', 'TicketController@show')->name('show');
        });
    });
    
    Route::post('/login', 'AuthController@login')->name('login');

    /**
     * Public routes
     * 
     */
    Route::group(['prefix' => 'public'], function () {


        /**
         * Tickets routes
         * 
         */
        Route::prefix('tickets')->name('tickets.')->group(function (){
            Route::post('/', 'TicketController@store')->name('store');
        });
   
        /**
         * Demands routes
         * 
         */
        Route::prefix('demands')->name('demands.')->group(function (){
            Route::get('/', 'DemandController@index')->name('index');
            Route::post('/', 'DemandController@store')->name('store');
        });
    });
});
