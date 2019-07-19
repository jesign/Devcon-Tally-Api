<?php

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


Route::prefix('/events')->group(function(){
   Route::get('/', 'EventController@index');
   Route::post('/', 'EventController@save');
   Route::post('/{id}/delete', 'EventController@delete');
});

Route::prefix('/participants')->group(function(){
    Route::get('/', 'ParticipantController@index');
    Route::post('/', 'ParticipantController@save');
    Route::post('/{id}/delete', 'ParticipantController@delete');
});

Route::prefix('/criteria')->group(function(){
    Route::get('/', 'CriteriaController@index');
    Route::post('/', 'CriteriaController@save');
    Route::post('/{id}/delete', 'CriteriaController@delete');
});
