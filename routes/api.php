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

Route::post('/login', 'LoginController@login');
Route::post('/register', 'RegisterController@register');

Route::middleware(['bindings', 'auth:api'])->group(function (){
    Route::post('/logout', 'UserController@logout');
    Route::get('/user', 'UserController@index');

    Route::prefix('/events')->group(function () {
        Route::get('/', 'EventController@index');
//        Route::get('/{event}/participants-scores', 'EventController@participantsScores');

        Route::prefix('/participants/{participant}')->group(function () {
            Route::post('/tally', 'TallyController@tally');
            Route::get('/scores', 'TallyController@getScores');
        });
    });
});

Route::middleware(['bindings', 'auth:api', 'role:admin'])->group(function () {
    Route::prefix('/events')->group(function () {
        Route::get('/', 'EventController@index');
        Route::post('/', 'EventController@save');
        Route::post('/{event}/use', 'EventController@use');
        Route::post('/{event}/delete', 'EventController@destroy');

        Route::prefix('{event}/participants')->group(function () {
            Route::get('/', 'ParticipantController@index');
            Route::post('/', 'ParticipantController@save');
            Route::post('/{id}/delete', 'ParticipantController@destroy');
            Route::get('/scores', 'ParticipantScoreController@getParticipantsScore');
        });

        Route::prefix('{event}/criteria')->group(function () {
            Route::get('/', 'CriteriaController@index');
            Route::post('/', 'CriteriaController@save');
            Route::post('/{id}/delete', 'CriteriaController@destroy');
        });
    });

    Route::prefix('/participants/{participant}')->group(function () {
        Route::post('/tally', 'TallyController@tally');
        Route::get('/scores', 'TallyController@getScores');
    });

    Route::prefix('/participant-scores')->group(function () {
        Route::get('/', 'ParticipantScoreController@index');
        Route::post('/', 'ParticipantScoreController@save');
    });
});

Route::get('/events/{event}/participants-scores', 'EventController@participantsScores');