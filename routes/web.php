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

    /**
     * Opened Tickets
     */
    Route::get('/', 'Tickets\TicketController@getOpenedTickets')->name('home');

    /**
     * Tickets Routes
     *
     */
    Route::namespace('Tickets')->name('tickets.')->prefix('tickets')->group(function (){

        Route::get('/in-progress', 'TicketController@getInProgressTickets')->name('in.progress');

        Route::get('/closed', 'TicketController@getClosedTickets')->name('closed');

        Route::get('/show/{id}', 'TicketController@showTicket')->name('show');

        Route::get('/response/{id}', 'TicketController@getResponseTicketView')->name('response.view');

        Route::post('/response/{id}', 'TicketController@responseTicket')->name('response');

        Route::get('/messages/{id}', 'TicketController@getTicketMessages')->name('messages');
    });

    /**
     * Demands routes
     *
     */
    Route::namespace('Demands')->group(function (){
        Route::resource('demands', 'DemandController');
        Route::get('demands/{id}/confirm/delete', 'DemandController@confirmDelete')->name('demands.confirmDelete');
    });

    /**
     * Users routes
     *
     */
    Route::namespace('Users')->group(function (){
        Route::resource('users', 'UserController');

        Route::prefix('users')->name('users.')->group(function (){
            Route::put('/{id}/restore', 'UserController@restore')->name('restore');
            Route::get('/{id}/confirm/delete', 'UserController@confirmDelete')->name('confirmDelete');
            Route::get('/{id}/confirm/restore', 'UserController@confirmRestore')->name('confirmRestore');
        });
    });

    /**
     * Systems routes
     *
     */
    Route::namespace('Systems')->group(function (){
        Route::resource('systems', 'SystemController', ['except' => ['show', 'edit', 'update']]);
        Route::get('systems/{token}/confirm/destroy', 'SystemController@confirmDestroy')->name('systems.confirmDestroy');
    });

    /**
     * Client Routes
     *
     */
    Route::namespace('Clients')->prefix('clients')->name('clients.')->group(function (){
        Route::get('/', 'ClientController@getAllClients')->name('index');
    });
});
