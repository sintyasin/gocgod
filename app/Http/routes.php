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
Route::get('myaccount/{id}', 'MemberController@readDataMember');

Route::get('productsample', 'ProductController@getMenuSample');
Route::post('eventsample', 'ProductController@eventsample');
Route::get('productsample/{id}', 'ProductController@productsample');
Route::post('productsample', 'ProductController@productsampledata');

Route::post('review/{id}', 'ProductController@giveTestimonial');


Route::get('faq', 'HomeController@faq_question');
Route::get('findalocation', 'MemberController@readAgent');

Route::get('checkout_subcriber', 'ProductController@getAllMenu');
Route::get('orderall_checkout', 'TransactionController@order_details');
Route::post('addtocart', 'TransactionController@addtocart');
Route::post('addtocartsubcriber/', 'TransactionController@addtocartsubcriber');
Route::post('updatecart/', 'TransactionController@updatecart');
Route::post('deletecart/', 'TransactionController@deletecart');
Route::get('profile/{id}', 'MemberController@showbalance');
Route::post('withdrawMoney', 'MemberController@withdrawMoney');
Route::post('edit_profile', 'MemberController@edit_profile');
Route::post('edit_password', 'MemberController@edit_password');
Route::get('becomeanagent', 'MemberController@bank');
Route::post('request_agent', 'MemberController@request_agent');

Route::get('customerorder', 'TransactionController@getOrderList');
Route::get('customerorder/data', array('as' => 'customerorderlist.data', 
		'uses' =>'TransactionController@getOrderData'));
Route::post('dataorderproduct', 'TransactionController@getProductOrder');
Route::post('sending', 'TransactionController@sending');

Route::get('myorder', 'TransactionController@getOrderListCustomer');
Route::get('myorder/data', array('as' => 'orderlistCustomer.data', 
	'uses' =>'TransactionController@getOrderDataCustomer'));
Route::get('edit/order/{id}', 'AdminController@getEditOrder');
Route::post('receive', 'TransactionController@receive');
Route::post('post/edit/order/{id}', 'AdminController@postEditOrder');
Route::post('product/order', 'AdminController@getProductOrder');

Route::get('historymyorder', 'TransactionController@getOrderListHistoryCustomer');
Route::get('historymyorder/data', array('as' => 'orderlistHistoryCustomer.data', 
	'uses' =>'TransactionController@getOrderDataHistoryCustomer'));
Route::post('historydatamyorder', 'TransactionController@getProductOrderHistoryCustomer');


Route::auth();

//////halaman admin
//auto update konfirmasi terima barang
Route::get('confirm/tx',
	'AdminController@getConfirmTx'
);

//LOGIN
Route::get('/general/log/in',
	'Auth\AdminAuthController@getLogin'
);
Route::post('/admin/login',
	'Auth\AdminAuthController@postLogin'
);
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
	//logout
	Route::get('/logout',
		'Auth\AdminAuthController@getLogout'
	);
	//admin profile
	Route::get('/edit/profile',
		'Auth\AdminAuthController@getEditProfile'
	);
	Route::post('/post/edit/profile',
		'Auth\AdminAuthController@postEditProfile'
	);
	Route::post('/change/password',
		'Auth\AdminAuthController@postChangePassword'
	);

	//new admin
	Route::get('list',
		'AdminController@getAdminList'
	);
	Route::get('admin/data', 
		array('as' => 'admin.data', 
			'uses' =>'AdminController@getAdminData')
	);
	Route::post('/delete/admin',
		'AdminController@deleteAdmin'
	);
	Route::get('add',
		'AdminController@getAddAdmin'
	);
	Route::post('/post/add/admin',
		'AdminController@postAddAdmin'
	);
	Route::get('edit/{id}',
		'AdminController@getEditAdmin'
	);
	Route::post('/post/edit/admin/{id}',
		'AdminController@postEditAdmin'
	);


	//PRODUCT
	Route::get('/product/list',
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

	//USER
	//customer
	Route::get('customer/list', 
		'AdminController@getCustomerList'
	);
	Route::get('customer/data', 
		array('as' => 'customerlist.data', 
			'uses' =>'AdminController@getCustomerData')
	);
	Route::get('customer/tx/data', 
		array('as' => 'customertx.data', 
			'uses' =>'AdminController@getCustomerTxData')
	);
	Route::get('edit/customer/tx/{id}',
		'AdminController@getEditCustomerTx'
	);
	Route::post('post/edit/customer/tx/{Oid}/{CId}',
		'AdminController@postEditCustomerTx'
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
	Route::get('agent/tx/data', 
		array('as' => 'agenttx.data', 
			'uses' =>'AdminController@getAgentTxData')
	);
	Route::get('edit/agent/tx/{id}', 
		'AdminController@getEditAgentTx'
	);
	Route::post('post/edit/agent/tx/{OId}/{AId}', 
		'AdminController@postEditAgentTx'
	);
	Route::get('agent/request/list', 
		'AdminController@getAgentRequestList'
	);
	Route::get('agent/request/data', 
		array('as' => 'agentrequest.data', 
			'uses' =>'AdminController@getAgentRequestData')
	);
	Route::post('process/agent/request', 
		'AdminController@getProcessAgentRequest'
	);

	//BANK
	Route::get('bank/list', 
		'AdminController@getBankList'
	);
	Route::get('bank/data', 
		array('as' => 'bank.data', 
			'uses' =>'AdminController@getBankData')
	);
	Route::post('delete/bank', 
		'AdminController@deleteBank'
	);	
	Route::get('insert/bank', 
		'AdminController@insertBank'
	);
	Route::post('post/bank', 
		'AdminController@postInsertBank'
	);
	Route::get('edit/bank/{id}', 
		'AdminController@getEditBank'
	);
	Route::post('post/edit/bank/{id}', 
		'AdminController@postEditBank'
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


	//TRANSACTION
	//order
	Route::get('order', 
		'AdminController@getOrderList'
	);
	Route::get('order/data', 
		array('as' => 'orderlist.data', 
			'uses' =>'AdminController@getOrderData')
	);
	Route::get('edit/order/{id}', 
		'AdminController@getEditOrder'
	);
	Route::post('post/edit/order/{id}', 
		'AdminController@postEditOrder'
	);
	Route::post('product/order', 
		'AdminController@getProductOrder'
	);
	//shipping
	Route::get('ship', 
		'AdminController@getShipList'
	);
	Route::get('ship/data', 
		array('as' => 'shiplist.data', 
			'uses' =>'AdminController@getShipData')
	);
	Route::get('edit/ship/{id}', 
		'AdminController@getEditShip'
	);
	Route::post('post/edit/ship/{id}', 
		'AdminController@postEditShip'
	);
	Route::post('product/ship', 
		'AdminController@getProductShip'
	);

	//PURCHASE
	Route::get('purchase', 
		'AdminController@getPurchaseList'
	);

	//REPORT
	Route::get('report/tx', 
		'AdminController@getTxReport'
	);
	Route::get('report/product', 
		'AdminController@getProductReport'
	);
});




Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');






Route::get('howtobuy', function(){
		return view('page.howtobuy');
});


Route::get('myorder', function(){
	return view('page.myorder');
});