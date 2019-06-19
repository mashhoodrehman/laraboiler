<?php

use App\Http\Controllers\LanguageController;

/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */


Route::get('test' , function(){
    // $user =  $request->user('api');
    $user = App\Models\Auth\User::find(1);
        $googleClient  = new App\Helpers\Google\GoogleClient('208-036-0101');
        $data  =$googleClient->getCampaigns();
        $label = [];
        $id = array();
        foreach ($data as $d){
            if(in_array($d['label'][0]['id'] , $id)){
                continue;
            }
            $id[] = $d['label'][0]['id'];
            $label[] = $d['label'][0];
        }
        return response()->json($label);
    });


    Route::post('change-campainst' , 'CampaignController@statusCampains')->name('change.campain.userpause' );
Route::post('change-campainst-enab' , 'CampaignController@statusCampainsEnab')->name('change.campain.userenab' );

Route::get('get-campain' , 'LanguageController@getCampain');


// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});
