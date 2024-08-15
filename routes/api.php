<?php
// header('Access-Control-Allow-Origin : *');
// header('Access-Control-Allow-Headers : Content-Type,X-Auth-Token,Authorization,Origin');
// header('Access-Control-Allow-Methods :GET, :POST, PUT, DELETE, OPTIONS');
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

//Route::group([
//	'middleware' => ['api','cors','throttle:60,1'],
//	'prefix' => 'api',
//], function($router){
//   Route::get('/test', 'UsersController@test');
//});

Route::group([ 'prefix' => 'auth'], function (){ 
    Route::group(['middleware' => ['guest:api','throttle:60,1']], function () {
        Route::post('login', 'API\AuthController@login');
        Route::post('signup', 'API\AuthController@signup');
        Route::post('getCodeSMS', 'API\AuthController@getCodeEmail');
        Route::post('verifyNumber', 'API\AuthController@verifyNumber');
        Route::post('uploadProfilePhoto', 'API\AuthController@uploadProfilePhoto');
    });
});  

Route::get('settings', 'API\SettingsControllerApi@settings');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('getReportInfo/{id}', 'API\IncidentController@getReportInfo');

    Route::get('logout', 'API\AuthController@logout');
    
    Route::get('getuser', 'API\AuthController@getUser');
    
    Route::post('createReport', 'API\IncidentController@createReport');

    
    Route::post('updateLogData', 'API\IncidentController@updateLogData');
    
    Route::post('getUserInfo', 'API\IncidentController@getUserInfo');

    Route::post('getLogData', 'API\IncidentController@getLogData');
    
    Route::get('getAnnouncements', 'API\AdvertisementController@getAnnouncements');

    Route::post('getDropOffPoints', 'API\IncidentController@getDropOffPoints');

    Route::post('getUsers', 'API\AuthController@getUsers');
    
    Route::get('check_user', 'API\AuthController@check_user');
    
    Route::get('getPopulatedData', 'API\IncidentController@getPopulatedData');
    
    Route::get('getProfileInfoByUserId/{id}', 'API\ProfileController@getProfileInfoByUserId');
    
    Route::get('getNotificationByUserId/{id}', 'API\ConversationsController@getNotificationByUserId');
    Route::post('getConversationsByUserId', 'API\ConversationsController@getConversationsByUserId');
    
    Route::get('checkIfTyping/{id}', 'API\ConversationsController@checkIfTyping');
    
    Route::get('getAboutApp', 'API\AuthController@getAboutApp');
    
    Route::post('searchUsers', 'API\ConversationsController@searchUsers');
    
    Route::post('getPendingRequest', 'API\ConversationsController@getPendingRequest');
    
    
    Route::post('getFriendsByUserId', 'API\ConversationsController@getFriendsByUserId');
    
    Route::post('sendRequest', 'API\ConversationsController@sendRequest');
    Route::post('acceptRequest', 'API\ConversationsController@acceptRequest');
    
    Route::post('getConversationById', 'API\ConversationsController@getConversationById');
    Route::post('addReply', 'API\ConversationsController@addReply');
    
    //gps admin
    Route::post('saveSignature', 'API\IncidentController@saveSignature');
    
    Route::post('uploadSignatureFiles', 'API\IncidentController@uploadSignatureFiles');

    //incident app
    Route::post('uploadReportFiles', 'API\AuthController@uploadReportFiles');
    Route::get('getReportById/{id}', 'API\AuthController@getReportById');
    
});