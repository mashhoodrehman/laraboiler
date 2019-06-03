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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/



Route::group([

    'middleware' => 'auth:api',
], function ($router) {
    Route::get('campaigns', 'CampaignController@getCampaigns');
    Route::get('change-campaign-status/{id}/{status}', 'CampaignController@changeStatus');
});
Route::post('login', 'AuthController@login');
Route::get('get-compains', 'AuthController@getcompains');
Route::get('status-compains/{id}/{status}', 'AuthController@statusCompain');

Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
