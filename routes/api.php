<?php
// header('Access-Control-Allow-Origin : *');
// header('Access-Control-Allow-Headers : Content-Type,X-Auth-Token,Authorization,Origin');
// header('Access-Control-Allow-Methods :GET, :POST, PUT, DELETE, OPTIONS');
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your Api!
|
*/

//Route::group([
//	'middleware' => ['Api','cors','throttle:60,1'],
//	'prefix' => 'Api',
//], function($router){
//   Route::get('/test', 'UsersController@test');
//});

Route::group([ 'prefix' => 'auth'], function (){ 
    Route::group(['middleware' => ['guest:Api','throttle:60,1']], function () {
        Route::post('login', 'Api\AuthController@login');
        Route::post('signup', 'Api\AuthController@signup');
        Route::post('getCodeSMS', 'Api\AuthController@getCodeEmail');
        Route::post('verifyNumber', 'Api\AuthController@verifyNumber');
        Route::post('uploadProfilePhoto', 'Api\AuthController@uploadProfilePhoto');
    });
});  

Route::get('settings', 'Api\SettingsControllerApi@settings');

Route::group(['middleware' => 'auth:Api'], function() {
    Route::get('getReportInfo/{id}', 'Api\IncidentController@getReportInfo');

    Route::get('logout', 'Api\AuthController@logout');
    
    Route::get('getuser', 'Api\AuthController@getUser');
    
    Route::post('createReport', 'Api\IncidentController@createReport');

    
    Route::post('updateLogData', 'Api\IncidentController@updateLogData');
    
    Route::post('getUserInfo', 'Api\IncidentController@getUserInfo');

    Route::post('getLogData', 'Api\IncidentController@getLogData');
    
    Route::get('getAnnouncements', 'Api\AdvertisementController@getAnnouncements');

    Route::post('getDropOffPoints', 'Api\IncidentController@getDropOffPoints');

    Route::post('getUsers', 'Api\AuthController@getUsers');
    
    Route::get('check_user', 'Api\AuthController@check_user');
    
    Route::get('getPopulatedData', 'Api\IncidentController@getPopulatedData');
    
    Route::get('getProfileInfoByUserId/{id}', 'Api\ProfileController@getProfileInfoByUserId');
    
    Route::get('getNotificationByUserId/{id}', 'Api\ConversationsController@getNotificationByUserId');
    Route::get('getConversationsByUserId', 'Api\ConversationsController@getConversationsByUserId');
    
    Route::get('checkIfTyping/{id}', 'Api\ConversationsController@checkIfTyping');
    
    Route::get('getAboutApp', 'Api\AuthController@getAboutApp');
    
    Route::post('searchUsers', 'Api\ConversationsController@searchUsers');
    
    Route::post('getPendingRequest', 'Api\ConversationsController@getPendingRequest');
    
    
    Route::post('getFriendsByUserId', 'Api\ConversationsController@getFriendsByUserId');
    
    Route::post('sendRequest', 'Api\ConversationsController@sendRequest');
    Route::post('acceptRequest', 'Api\ConversationsController@acceptRequest');
    
    Route::post('getConversationById', 'Api\ConversationsController@getConversationById');
    Route::post('addReply', 'Api\ConversationsController@addReply');
    
    //gps admin
    Route::post('saveSignature', 'Api\IncidentController@saveSignature');
    
    Route::post('uploadSignatureFiles', 'Api\IncidentController@uploadSignatureFiles');

    //incident app
    Route::post('uploadReportFiles', 'Api\AuthController@uploadReportFiles');
    Route::get('getReportById/{id}', 'Api\AuthController@getReportById');
    
});