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
Route::get('register/', 'MemberController@registerMemberPage');
Route::get('registerAdmin/', 'MemberController@registerAdminPage');
Route::post('register/submit', 'MemberController@registerMember');
Route::post('register/submitAdmin', 'MemberController@registerAdmin');

//////login
Route::get('login/', 'MemberController@loginPageMember');
Route::post('login/submit', 'MemberController@checkLoginMember');

//////tes
Route::get('findalocation', function(){
        return view('page.findalocation');

});

Route::get('menu', function(){
        return view('page.menu');

});

Route::get('checkout', function(){
        return view('page.checkout');

});