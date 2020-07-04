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
use App\Notifications\approveFollowRequestNotification ;
use App\Http\Resources\QuestionResource;

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/showProfile/{id}' , 'UserController@show')->middleware('auth')->name('showProfile');
Route::post('/searchUser' , 'UserController@searchUser')->name('searchForUser');

Route::post('/sendFollowRequest' , 'UserController@sendFollowRequest')->middleware('auth');
Route::post('/approveFollowRequest' , 'UserController@approveFollowRequest')->middleware('auth');
Route::post('/unfollow' , 'UserController@unfollow')->middleware('auth');
Route::post('/declineSentFollowRequest' , 'UserController@declineSentFollowRequest')->middleware('auth');
Route::post('/declineReceivedFollowRequest' , 'UserController@declineReceivedFollowRequest')->middleware('auth');

Route::post('/askQuestion' , 'QuestionController@store')->middleware('auth');
Route::get('/showQuestion/{id}' , 'QuestionController@show')->middleware('auth')->name('showQuestion');

Route::post('/answerQuestion' , 'AnswerController@store')->middleware('auth');
Route::get('/answerQuestion/{id}' , 'AnswerController@create')->middleware('auth') ;

Route::post('/likeQuestion' , 'QuestionController@like')->middleware('auth');
Route::post('/unlikeQuestion' , 'QuestionController@unlike')->middleware('auth');

Route::get('/questions' , 'QuestionController@index')->middleware('auth');
Route::get('/questionsForUser' , 'QuestionController@questionsForUser')->middleware('auth');

Route::get('/newNotificationsStatus' , 'NotificationController@getNumberOfNewNotification')->middleware('auth');

Route::get('/notifications/{type}' , 'NotificationController@notificationsPageFactory')->middleware('auth');
Route::post('/readApproveFollowRequestNotifications' , 'NotificationController@readApproveFollowRequestNotifications')->middleware('auth');
Route::post('/readQuestionLikedNotifications' , 'NotificationController@readQuestionLikedNotifications')->middleware('auth');
Route::post('/readQuestionAnsweredNotifications' ,'NotificationController@readQuestionAnsweredNotifications' )->middleware('auth');
