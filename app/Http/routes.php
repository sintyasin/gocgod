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

Route::get('/', function () {
    return view('welcome');
});


Route::get('home', ['uses' => 'HomeController@index']);
Route::get('productDetail/{id}', 'ProductController@getMenuDetail');
Route::get('product/', 'ProductController@getMenu');

//////register member/admin baru
Route::get('register/', 'MemberController@getRegisterMember');
Route::get('registerAdmin/', 'MemberController@getRegisterAdmin');
Route::post('register/submit', 'MemberController@postRegisterMember');
Route::post('register/submitAdmin', 'MemberController@postRegisterAdmin');

//////login
Route::get('login/', 'MemberController@getLoginMember');
Route::post('login/submit', 'MemberController@postLoginMember');

//login page dan register laravel
Route::controllers([
		'auth' => 'Auth\AuthController',
		'password' => 'Auth\PasswordController',
	]);

Route::auth();
