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
Route::get('productDetail/{id}', 'ProductController@getMenuDetail');
Route::get('menu/', 'ProductController@getMenu');

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

/*
Route::get('menu', function(){
        return view('page.menu');

});*/

Route::get('checkout', function(){
        return view('page.checkout');

});
