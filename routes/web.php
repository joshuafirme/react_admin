<?php

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
Auth::routes();



Route::get('/openstreetmap/test', function () {
  $geocode=file_get_contents("https://nominatim.openstreetmap.org/search.php?q=48.886,2.343&polygon_geojson=1&format=json");
    
  $output= json_decode($geocode);
  return $output;
});

Route::get('/pusher-demo', function () {
  return view('test');
});

Route::get('/pusher-demo/trigger', function () {
  event(new App\Events\StatusLiked('Someone'));
  return "Event has been sent!";
});


Route::get('/', function () {
    return view('auth.login');
});

Route::post('loginUser',[
            'uses'=>'UsersController@authenticate',
              'as'=>'loginUser'
]);

Route::post('register',[
            'uses'=>'UsersController@register',
              'as'=>'register'
]);

Route::get('/catalog/tracking/monitor', 'TrackingController@monitor');
Route::get('/catalog/tracking/getsearchdata', 'TrackingController@getsearchdata');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('/home/loadDataDashboard', 'HomeController@loadDataDashboard');
    Route::post('/catalog/user/updateAll', 'HomeController@update');    

    //Users
    Route::get('/catalog/users', 'UsersController@index')->name('/catalog/users');
    Route::get('/catalog/adminUsers', 'UsersController@indexAdmin')->name('/catalog/adminUsers');
    
    Route::get('/catalog/users/add', 'UsersController@create')->name('/catalog/users/add');
    Route::get('/catalog/users/add-admin', 'UsersController@createAdmin')->name('/catalog/users/add-admin');
    Route::get('/catalog/user/edit/{id}', 'UsersController@edit');
    Route::get('/catalog/user/show/{id}', 'UsersController@show');
    Route::post('/catalog/user/storeStaff', 'UsersController@storeStaff');
    Route::post('/catalog/user/storeAdmin', 'UsersController@storeAdmin');
    Route::post('/catalog/user/update', 'UsersController@update');
    Route::get('/catalog/user/delete/{id}', 'UsersController@destroy');
    Route::post('/catalog/user/updateQtyAssigned', 'UsersController@updateQtyAssigned');

    //Roles
    Route::get('/catalog/roles', 'RolesController@index')->name('/catalog/roles');
    Route::get('/catalog/roles/add', 'RolesController@create')->name('/catalog/roles/add');
    Route::get('/catalog/roles/edit/{id}', 'RolesController@edit');
    Route::get('/catalog/roles/show/{id}', 'RolesController@show');
    Route::post('/catalog/roles/store', 'RolesController@store');
    Route::post('/catalog/roles/update', 'RolesController@update');
    Route::get('/catalog/roles/delete/{id}', 'RolesController@destroy');

    //Agencies
    Route::get('/catalog/agencies', 'AgenciesController@index')->name('/catalog/agencies');
    Route::get('/catalog/agencies/add', 'AgenciesController@create')->name('/catalog/agencies/add');
    Route::get('/catalog/agencies/edit/{id}', 'AgenciesController@edit');
    Route::get('/catalog/agencies/show/{id}', 'AgenciesController@show');
    Route::post('/catalog/agencies/store', 'AgenciesController@store');
    Route::post('/catalog/agencies/update', 'AgenciesController@update');
    Route::get('/catalog/agencies/delete/{id}', 'AgenciesController@destroy');
    
    //Categories
    Route::get('/catalog/categories', 'CategoriesController@index')->name('/catalog/categories');
    Route::get('/catalog/categories/add', 'CategoriesController@create')->name('/catalog/agencies/add');
    Route::get('/catalog/categories/edit/{id}', 'CategoriesController@edit');
    Route::get('/catalog/categories/show/{id}', 'CategoriesController@show');
    Route::post('/catalog/categories/store', 'CategoriesController@store');
    Route::post('/catalog/categories/update', 'CategoriesController@update');
    Route::get('/catalog/categories/delete/{id}', 'CategoriesController@destroy');

    //Sub categories
    Route::get('/catalog/subcategories', 'SubCategoriesController@index')->name('/catalog/sub-categories');
    Route::get('/catalog/subcategories/add', 'SubCategoriesController@create')->name('/catalog/agencies/add');
    Route::get('/catalog/subcategories/edit/{id}', 'SubCategoriesController@edit');
    Route::get('/catalog/subcategories/show/{id}', 'SubCategoriesController@show');
    Route::post('/catalog/subcategories/store', 'SubCategoriesController@store');
    Route::post('/catalog/subcategories/update', 'SubCategoriesController@update');
    Route::get('/catalog/subcategories/delete/{id}', 'SubCategoriesController@destroy');

    //logs
    Route::get('/catalog/logs', 'LogsController@index')->name('/catalog/logs');
    Route::get('/catalog/logs/add', 'LogsController@create')->name('/catalog/logs/add');
    Route::get('/catalog/logs/edit/{id}', 'LogsController@edit');
    Route::get('/catalog/logs/show/{id}', 'LogsController@show');
    Route::post('/catalog/logs/store', 'LogsController@store');
    Route::post('/catalog/logs/update', 'LogsController@updateIncident');
    Route::get('/catalog/logs/delete/{id}', 'LogsController@destroy');
    Route::post('/catalog/logs/updateStatus', 'LogsController@updateStatus');
    
    
    //announcements
    Route::get('/catalog/announcements', 'AdvertisementController@index')->name('/catalog/announcements');
    Route::get('/catalog/announcements/add', 'AdvertisementController@create')->name('/catalog/announcements/add');
    Route::get('/catalog/announcements/edit/{id}', 'AdvertisementController@edit');
    Route::get('/catalog/announcements/show/{id}', 'AdvertisementController@show');
    Route::post('/catalog/announcements/store', 'AdvertisementController@store');
    Route::post('/catalog/announcements/update', 'AdvertisementController@update');
    Route::get('/catalog/announcements/delete/{id}', 'AdvertisementController@destroy');
    Route::post('/catalog/announcements/uploadAnnouncementFiles', 'AdvertisementController@uploadAnnouncementFiles');

    Route::get('/catalog/settings', 'SettingsController@index')->name('/catalog/settings');
    Route::post('/catalog/settings/update', 'SettingsController@update')->name('/catalog/settings/update');

    //reports
    Route::get('/catalog/reports', 'LogsController@reports')->name('/catalog/reports');
    Route::post('/catalog/reports/search', 'LogsController@searchreport');
    Route::post('getReports', 'LogsController@getReports' )->name('getReports');
    Route::post('/catalog/reports/importReportFile', 'LogsController@importReportFile');
    Route::get('/catalog/reports/exportReportFile', 'LogsController@exportReportFile');

     //messaging
     Route::get('/catalog/messaging', 'ConversationsController@index')->name('/catalog/messaging');
     Route::get('/catalog/messaging/add', 'ConversationsController@create')->name('/catalog/messaging/add');
     Route::get('/catalog/messaging/edit/{id}', 'ConversationsController@edit');
     Route::get('/catalog/messaging/show/{id}', 'ConversationsController@show');
     Route::post('/catalog/messaging/store', 'ConversationsController@store');
     Route::post('/catalog/messaging/update', 'ConversationsController@update');
     Route::get('/catalog/messaging/delete/{id}', 'ConversationsController@destroy');
     Route::post('/catalog/messaging/uploadMessagingFiles', 'ConversationsController@uploadMessagingFiles');
     Route::post('/catalog/messaging/getConversationById', 'ConversationsController@getConversationById');
     Route::post('/catalog/messaging/addReply', 'ConversationsController@addReply');
    
    
    //Transactions
    Route::get('/catalog/transactions', 'TransactionsController@index')->name('/catalog/transactions');
    
    //notification

    //dropoff points
    Route::post('/catalog/getDropOffPoints', 'LogsController@getDropOffPoints');
        
    Route::get('/testpage', 'UsersController@test')->name('testpage');


    //Tracking / Tracing Packages
     Route::get('/catalog/tracking', 'TrackingController@index')->name('/catalog/tracking');
     Route::get('/catalog/tracking/report', 'TrackingController@report')->name('/catalog/tracking/report');

     Route::get('/catalog/tracking/add', 'TrackingController@create')->name('/catalog/tracking/add');

     Route::get('/catalog/tracking/fetch_data', 'TrackingController@fetch_data');
     Route::get('/catalog/tracking/report/fetch_data', 'TrackingController@fetch_data_report');

     Route::get('/catalog/tracking/edit/{id}', 'TrackingController@edit');
     Route::get('/catalog/tracking/show/{id}', 'TrackingController@show');
     Route::post('/catalog/tracking/store', 'TrackingController@store');
     Route::post('/catalog/tracking/update', 'TrackingController@update');
     Route::get('/catalog/tracking/delete/{id}', 'TrackingController@destroy');
     Route::get('/catalog/tracking/update_data', 'TrackingController@update_data');
     Route::post('importTracking', 'TrackingController@import')->name('importTracking');
     Route::get('/catalog/tracking/report/exportTracking', 'TrackingController@export')->name('exportTracking');
     Route::get('/catalog/tracking/report/exportTrackingPerRider', 'TrackingController@exportTrackingPerRider')->name('exportTrackingPerRider');

     
     Route::get('/catalog/tracking/update_status', 'TrackingController@update_status');
     Route::get('/catalog/tracking/updatestatus', 'TrackingController@updatestatus');
     Route::post('/catalog/tracking/update_status_del', 'TrackingController@update_status_del');
     
});