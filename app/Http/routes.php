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
Route::post('review/{id}', 'ProductController@giveTestimonial');
Route::get('checkout', 'ProductController@getAllMenu');
Route::get('faq', 'HomeController@faq_question');
Route::get('findalocation', 'MemberController@readAgent');
Route::post('orderall', 'TransactionController@transactionAll');
Route::post('addtocart/', 'TransactionController@addcart');
Route::post('updatecart/', 'TransactionController@updatecart');
Route::post('deletecart/', 'TransactionController@deletecart');

Route::auth();

//////halaman admin
//product
Route::group(['prefix' => 'admin'], function () {
	
	//PRODUCT
	Route::get('/',
			'AdminController@getProductList'
	);
	Route::get('productlist/data', 
		array('as' => 'productlist.data', 
			'uses' =>'AdminController@getProductData')
	);
	Route::get('insert/product', 
		'AdminController@getInsertProduct'
	);
	Route::post('post/product', 
		'AdminController@postInsertProduct'
	);
	Route::get('edit/product/{id}', 
		'AdminController@getEditProduct'
	);
	Route::post('post/edit/product/{id}', 
		'AdminController@postEditProduct'
	);
	Route::post('delete/product', 
		'AdminController@getDeleteProduct'
	);

	

	Route::get('category/list', 
		'AdminController@getCategoryList'
	);	
	Route::get('category/data', 
		array('as' => 'categorylist.data', 
			'uses' =>'AdminController@getCategoryData')
	);
	Route::get('edit/category/{id}', 
		'AdminController@getEditCategory'
	);
	Route::post('post/category/{id}', 
		'AdminController@postEditCategory'
	);
	Route::post('delete/category', 
		'AdminController@getDeleteCategory'
	);


	Route::get('testimonial/list/', 
		'AdminController@getTestimonialList'
	);
	Route::get('testimonial/data', 
		array('as' => 'testimoniallist.data', 
			'uses' =>'AdminController@getTestimonialData')
	);
	Route::post('delete/testimoni', 
		'AdminController@getDeleteTestimoni'
	);

	Route::get('testimonial/request/', 
		'AdminController@getTestimonialRequest'
	);
	Route::get('process/testimonial/data', 
		array('as' => 'processtestimonial.data', 
			'uses' =>'AdminController@getProcessTestimonialData')
	);
	Route::post('process/testimoni', 
		'AdminController@getProcessTestimoni'
	);

	Route::get('sample/request', 
		'AdminController@getSampleRequest'
	);
	Route::get('samplerequest/data', 
		array('as' => 'samplerequest.data', 
			'uses' => 'AdminController@getSampleData')
	);
	Route::post('process/sample/request', 
		'AdminController@getProcessSampleRequest'
	);
	Route::post('sample/request/detail', 
		'AdminController@getSampleDetail'
	);
	/*Route::get('sample/request/detail', 
		'AdminController@tes'
	);*/

	//USER
	//customer
	Route::get('customer/list', 
		'AdminController@getCustomerList'
	);
	Route::get('customer/data', 
		array('as' => 'customerlist.data', 
			'uses' =>'AdminController@getCustomerData')
	);
	Route::get('edit/customer/{id}', 
		'AdminController@getEditCustomer'
	);
	Route::post('post/edit/customer/{id}', 
		'AdminController@postEditCustomer'
	);

	//agent
	Route::get('agent/list', 
		'AdminController@getAgentList'
	);
	Route::get('agent/data', 
		array('as' => 'agentlist.data', 
			'uses' =>'AdminController@getAgentData')
	);
	Route::get('edit/agent/{id}', 
		'AdminController@getEditAgent'
	);
	Route::post('post/edit/agent/{id}', 
		'AdminController@postEditAgent'
	);
	Route::get('review/agent', 
		'AdminController@getReviewAgent'
	);
	Route::get('reviewagent/data', 
		array('as' => 'reviewagent.data', 
			'uses' =>'AdminController@getReviewAgentList')
	);
	Route::post('delete/review/agent', 
		'AdminController@getDeleteReviewAgent'
	);
	Route::get('review/agent/request', 
		'AdminController@getReviewAgentRequest'
	);
	Route::get('processreviewagent/data', 
		array('as' => 'processreviewagent.data', 
			'uses' =>'AdminController@getProcessReviewAgentList')
	);
	Route::post('process/review/agent', 
		'AdminController@getProcessReviewAgent'
	);


	//FAQ
	Route::get('faq/list', 
		'AdminController@getFaqList'
	);
	Route::get('faq/data', 
		array('as' => 'faqlist.data', 
			'uses' =>'AdminController@getFaqData')
	);
	Route::post('delete/faq', 
		'AdminController@getDeleteFaq'
	);	
	Route::get('edit/faq/{id}', 
		'AdminController@getEditFaq'
	);
	Route::post('post/edit/faq/{id}', 
		'AdminController@postEditFaq'
	);
	Route::get('insert/faq', 
		'AdminController@getInsertFaq'
	);
	Route::post('post/faq', 
		'AdminController@postInsertFaq'
	);


	//CITY
	Route::get('city/list', 
		'AdminController@getCityList'
	);
	Route::get('city/data', 
		array('as' => 'citylist.data', 
			'uses' =>'AdminController@getCityData')
	);
	Route::get('edit/city/{id}', 
		'AdminController@getEditCity'
	);
	Route::post('post/edit/city/{id}', 
		'AdminController@postEditCity'
	);
	Route::post('delete/city', 
		'AdminController@deleteCity'
	);
	Route::get('insert/city', 
		'AdminController@insertCity'
	);
	Route::post('post/city', 
		'AdminController@postInsertCity'
	);

	//ABOUT US
	Route::get('aboutus', 
		'AdminController@getAboutUs'
	);
	Route::post('post/aboutus/{id}',
		'AdminController@postAboutUs'
	);


	//BANNER
	Route::get('banner/list', 
		'AdminController@getBannerList'
	);


	//CUT OFF DATE
	Route::get('cut/off/date', 
		'AdminController@getCutOffDate'
	);
	Route::post('post/cut/off/date', 
		'AdminController@postCutOffDate'
	);
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

Route::get('customerorder', function(){
	return view('page.customerorder');
});