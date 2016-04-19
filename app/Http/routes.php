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
Route::get('register/', 'MemberController@register');
Route::post('register/submit', 'MemberController@registerSubmit');
