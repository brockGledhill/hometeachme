<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/', function() {
	return redirect('/dashboard');
});
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'Auth\AuthController@getLogout');
Route::get('/signup', function() {
	return view('signup');
});

Route::controller('/dashboard', 'DashboardController');
Route::controller('/notifications', 'NotificationController');
Route::controller('/messages', 'MessageController');
Route::controller('/profile/password', 'Profile\PasswordController');
Route::controller('/profile', 'ProfileController');
Route::controller('/visit', 'VisitController');
Route::controller('/comment', 'CommentController');
Route::controller('/companionships/districts', 'CompanionshipDistrictController');
Route::controller('/companionships/members', 'CompanionshipMemberController');
Route::controller('/companionships', 'CompanionshipController');
Route::controller('/members/password', 'Members\PasswordController');
Route::controller('/members', 'MemberController');
Route::controller('/districts', 'DistrictController');
Route::controller('/stats', 'StatisticsController');