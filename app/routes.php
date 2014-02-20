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

Route::any('/', 'DispatchController@index');
Route::any('recurringDispatcher', 'DispatchController@recurringDispatcher');
Route::any('storeSingleDispatcher', 'DispatchController@storeSingleDispatcher');
Route::any('storeRecurringDispatcher', 'DispatchController@storeRecurringDispatcher');
Route::any('findDispatchers', 'DispatchController@findDispatchers');
Route::any('fetchResult', 'DispatchController@fetchResult');

/*Route::get('/', function()
{
	return View::make('hello');
});*/
