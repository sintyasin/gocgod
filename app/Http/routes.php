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

Route::get('home', ['uses' => 'HomeController@index']);
Route::get('/', 'HomeController@index');
Route::get('menu_detail/{id}', 'ProductController@getMenuDetail');
Route::get('menu/', 'ProductController@getMenu');

Route::auth();

//////tes

Route::get('findalocation', function(){
        return view('page.findalocation');

});

/*
Route::get('menu', function(){
        return view('page.menu');

});*/

Route::get('checkout', function(){
        return view('page.checkout');

});

Route::get('faq', function(){
		return view('page.faq');
});

Route::get('becomeanagent', function(){
		return view('page.becomeanagent');
});

Route::get('howtobuy', function(){
		return view('page.howtobuy');
});

