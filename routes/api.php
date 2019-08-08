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
        Route::prefix('/{event}')->group(function(){
            Route::get('/participants-scores', 'EventController@participantsScores');
            Route::get('/participants/scores', 'ParticipantScoreController@getParticipantsScore');
            Route::get('/participants', 'ParticipantController@index');
            Route::get('/criteria/', 'CriteriaController@index');
            Route::get('/judges', 'EventController@judges');
        });
    });

    Route::prefix('/participants/{participant}')->group(function () {
        Route::post('/tally', 'TallyController@tally');
        Route::get('/tally', 'TallyController@getCurrentJudgeScore');
        Route::get('/scores', 'ParticipantController@getScores');
        Route::get('/judge/{user}/scores', 'ParticipantController@getScoreFromJudge');
    });
});

Route::middleware(['bindings', 'auth:api', 'role:admin'])->group(function () {
    Route::prefix('/events')->group(function () {
        Route::post('/', 'EventController@save');
        Route::post('/{event}/use', 'EventController@use');
        Route::post('/{event}/delete', 'EventController@destroy');

        Route::prefix('{event}/participants')->group(function () {
            Route::post('/', 'ParticipantController@save');
            Route::post('/{id}/delete', 'ParticipantController@destroy');
        });

        Route::prefix('{event}/criteria')->group(function () {
            Route::post('/', 'CriteriaController@save');
            Route::post('/{id}/delete', 'CriteriaController@destroy');
        });

        Route::post('/{event}/assign-judges', 'EventController@assignJudges');
        Route::post('/{event}/remove-judge', 'EventController@removeJudge');
    });

    Route::prefix('/judges')->group(function(){
        Route::get('/', 'UserController@getJudges');
        Route::post('/', 'UserController@saveJudge');
        Route::post('/{user}/delete', 'UserController@deleteJudge');
    });

    Route::prefix('/participant-scores')->group(function () {
        Route::get('/', 'ParticipantScoreController@index');
        Route::post('/', 'ParticipantScoreController@save');
    });
});
