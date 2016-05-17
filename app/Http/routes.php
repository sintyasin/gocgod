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

//////halaman admin
//product
Route::get('adminproductlist/{status}', 'AdminController@getProductList');
Route::get('productlist/data', array('as' => 'productlist.data', 'uses' =>'AdminController@getProductData'));
Route::get('admininsertproduct/{status}', 'AdminController@getInsertProduct');
Route::get('admindeleteproduct/{id}', 'AdminController@getDeleteProduct');
Route::post('adminpostproduct', 'AdminController@postInsertProduct');
Route::get('admineditproduct/{id}', 'AdminController@getEditProduct');
Route::post('adminposteditproduct/{id}', 'AdminController@postEditProduct');
Route::get('admincategorylist/{status}', 'AdminController@getCategoryList');
Route::get('category/data', array('as' => 'categorylist.data', 'uses' =>'AdminController@getCategoryData'));
Route::get('admineditcategory/{id}', 'AdminController@getEditCategory');
Route::post('adminpostcategory/{id}', 'AdminController@postEditCategory');
Route::get('admintestimoniallist/{status}', 'AdminController@getTestimonialList');
Route::get('testimonial/data', array('as' => 'testimoniallist.data', 'uses' =>'AdminController@getTestimonialData'));
Route::get('admindeletetestimoni/{array}', 'AdminController@getDeleteTestimoni');
Route::get('admintestimonialrequest/{status}', 'AdminController@getTestimonialRequest');
Route::get('processtestimonial/data', array('as' => 'processtestimonial.data', 'uses' =>'AdminController@getProcessTestimonialData'));
Route::get('adminprocesstestimoni/{action}/{array}', 'AdminController@getProcessTestimoni');

//FAQ
Route::get('adminfaqlist/{status}', 'AdminController@getFaqList');
Route::get('faq/data', array('as' => 'faqlist.data', 'uses' =>'AdminController@getFaqData'));
Route::get('admindeletefaq/{id}', 'AdminController@getDeleteFaq');
Route::get('admininsertfaq/{status}', 'AdminController@getInsertFaq');
Route::post('adminpostfaq', 'AdminController@postInsertFaq');
Route::get('admineditfaq/{id}', 'AdminController@getEditFaq');
Route::post('adminposteditfaq/{id}', 'AdminController@postEditFaq');

//customer
Route::get('admincustomerlist/{status}', 'AdminController@getCustomerList');
Route::get('customer/data', array('as' => 'customerlist.data', 'uses' =>'AdminController@getCustomerData'));
Route::get('admineditcustomer/{id}', 'AdminController@getEditCustomer');
Route::post('adminposteditcustomer/{id}', 'AdminController@postEditCustomer');

//agent
Route::get('adminagentlist/{status}', 'AdminController@getAgentList');
Route::get('agent/data', array('as' => 'agentlist.data', 'uses' =>'AdminController@getAgentData'));
Route::get('admineditagent/{id}', 'AdminController@getEditAgent');
Route::post('adminposteditagent/{id}', 'AdminController@postEditAgent');
Route::get('adminreviewagent/{status}', 'AdminController@getReviewAgent');
Route::get('reviewagent/data', array('as' => 'reviewagent.data', 'uses' =>'AdminController@getReviewAgentList'));
Route::get('admindeletereviewagent/{array}', 'AdminController@getDeleteReviewAgent');
Route::get('adminreviewagentrequest/{status}', 'AdminController@getReviewAgentRequest');
Route::get('processreviewagent/data', array('as' => 'processreviewagent.data', 'uses' =>'AdminController@getProcessReviewAgentList'));
Route::get('adminprocessreviewagent/{action}/{array}', 'AdminController@getProcessReviewAgent');

//city
Route::get('admincitylist/{status}', 'AdminController@getCityList');
Route::get('city/data', array('as' => 'citylist.data', 'uses' =>'AdminController@getCityData'));
Route::get('admindeletecity/{id}', 'AdminController@deleteCity');
Route::get('admininsertcity/{status}', 'AdminController@insertCity');
Route::post('adminpostcity', 'AdminController@postInsertCity');
Route::get('admineditcity/{id}', 'AdminController@getEditCity');
Route::post('adminposteditcity/{id}', 'AdminController@postEditCity');

//about us
Route::get('adminaboutus/{status}', 'AdminController@getAboutUs');
Route::post('adminpostaboutus/{id}','AdminController@postAboutUs');

Route::get('findalocation', function(){
        return view('page.findalocation');
});

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

