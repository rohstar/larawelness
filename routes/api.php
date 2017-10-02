<?php

use Illuminate\Http\Request;

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

Route::prefix('user')->group(function () {

    Route::get('{id}/wellness-record/{wellnessRecordId}/{date}', 'WellnessRecordController@show');

    Route::post('{id}/wellness-record', 'WellnessRecordController@store');

    Route::delete('{id}/wellness-record/{wellnessRecordId}/question/{questionId}', 'WellnessRecordController@destroy');

});