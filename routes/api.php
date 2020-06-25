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

    });

    /**
     * Endpoints consumed by
     * others systems
     *
     */
    Route::group(['middleware' => 'apiToken'], function () {

        Route::prefix('tickets')->name('tickets.')->group(function (){

            Route::get('/{clientEmail}', 'TicketController@getClientTickets');

            Route::get('/info/{ticketID}', 'TicketController@getAllTicketInfos');

            Route::post('/', 'TicketController@openTicket');

            Route::post('/client-response', 'TicketController@storeClientResponse');

            Route::delete('/close/{ticketID}', 'TicketController@closeTicket');
        });

        /**
         * Tickets routes
         *

        Route::prefix('tickets')->name('tickets.')->group(function (){

            Route::get('/{clientEmail}', 'TicketController@clientTickets')->name('client');

            Route::get('/{clientEmail}/{ticketID}', 'TicketController@showTicket')->name('show');

            Route::get('/responses/support/{ticketID}', 'TicketController@responsesFromSuport')->name('responses.from.support');
            Route::get('/responses/client/{ticketID}', 'TicketController@responsesFromClient')->name('responses.from.client');

            Route::post('/', 'TicketController@store')->name('store');
            Route::post('/responses/client/{ticketID}', 'TicketController@storeClientResponse')->name('store.responses.client');

        });
         *  */

        /**
         * Demands routes
         *
         */
        Route::prefix('demands')->name('demands.')->group(function (){
            Route::get('/', 'DemandController@index')->name('index');
        });
    });
});
