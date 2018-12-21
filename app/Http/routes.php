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

Route::get('login', function () {
    return view('login');
});

//Route::any('service/validate_code/create', 'service\ValidateCodeControler@create');
//Route::get('/login', 'View\MemberController@tologin');
//Route::get('/register', 'View\MemberController@register');
//Route::get('/category', 'View\BookController@toCategory');
//Route::post('service/register', 'service\MemberController@register');
//Route::any('service/validate_phone/send', 'service\ValidateCodeControler@sendSMS');

//Route::any('service/validate_email', 'service\ValidateCodeControler@validateEmail');//验证邮箱

//Route::post('service/login', 'service\MemberController@login');//验证登录信息

	Route::get('/login', 'View\MemberController@tologin');
	Route::get('/register', 'View\MemberController@register');
	Route::get('/category', 'View\bookController@toCategory');
	Route::get('/product/category_id/{catefory_id}', 'View\bookController@toProduct');
	Route::get('/product/{product_id}', 'View\bookController@toPdtContent');

Route::group(['prefix' => 'service'],function(){
	Route::any('validate_code/create', 'service\ValidateCodeControler@create');
	Route::any('validate_email', 'service\ValidateCodeControler@validateEmail');//验证邮箱
	Route::post('login', 'service\MemberController@login');//验证登录信息
	Route::any('validate_phone/send', 'service\ValidateCodeControler@sendSMS');
	Route::get('category/parent_id/{parent_id}', 'service\BookController@getCategoryParentId');
	Route::get('cart/add/{product_id}', 'service\CartController@addCart');
});