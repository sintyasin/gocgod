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
Route::get('productsample', 'ProductController@getMenuSample');
Route::get('myaccount/{id}', 'MemberController@readDataMember');
Route::get('review', 'ProductController@giveTestimonial');
Route::get('checkout', 'ProductController@getAllMenu');
Route::get('faq', 'HomeController@faq_question');

Route::auth();

//////halaman admin
Route::get('adminproductlist', 'AdminController@showProductList');
Route::get('productlist/data', array('as' => 'productlist.data', 'uses' =>'AdminController@getProductList'));
Route::get('admincustomerlist', 'AdminController@showCustomerList');
Route::get('customer/data', array('as' => 'customerlist.data', 'uses' =>'AdminController@getCustomerList'));
Route::get('adminagentlist', 'AdminController@showAgentList');
Route::get('agent/data', array('as' => 'agentlist.data', 'uses' =>'AdminController@getAgentList'));



Route::get('findalocation', function(){
        return view('page.findalocation');
});

Route::get('becomeanagent', function(){
		return view('page.becomeanagent');
});

Route::get('howtobuy', function(){
		return view('page.howtobuy');
});

Route::get('profile', function(){
	return view('page.profile');
});

Route::get('myorder', function(){
	return view('page.myorder');
});