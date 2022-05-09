<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@welcome');
Route::get('/signin', 'AuthController@signin');
Route::get('/callback', 'AuthController@callback');
Route::get('/signout', 'AuthController@signout');
Route::get('/sendamrit', 'CalendarController@reply');
Route::get('/calendar', 'CalendarController@calendar');
Route::get('/messageA', 'CalendarController@amritmail');
Route::get('/calendar/new', 'CalendarController@getNewEventForm');
Route::post('/calendar/new', 'CalendarController@createNewEvent');
Route::get('/calendarA', 'PatroController@patro');
Route::get('/emailA', 'EmailController@upload');
Route::post('/eventSend',[
    'uses'=>'fileController@createNewEvent',
    'as'=>'messageSend'
]);
Route::post('/messagedownload',[
    'uses'=>'CalendarController@download',
    'as'=>'messagedownload'
]);
Route::post('/messageUpload',[
    'uses'=>'fileController@index',
    'as'=>'messageUpload'
]);
Route::post('/messageSend',[
    'uses'=>'CalendarController@attach',
    'as'=>'messageSend'
]);















/*Route::get('/sendamrit',[
    'uses'=>'CalendarController@amritmail',
    'as'=>'sendamrit'
]);*/

/*
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@welcome');

Route::get('/signin', 'AuthController@signin');
Route::get('/callback', 'AuthController@callback');
Route::get('/signout', 'AuthController@signout');
Route::get('/viewMessage', 'CalendarController@viewMessage');
Route::get('/calendar/new', 'CalendarController@getNewEventForm');
Route::post('/calendar/new', 'CalendarController@createNewEvent');
*/
