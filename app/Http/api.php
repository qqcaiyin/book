<?php
	/**
	 * Api
	 */

	Route::post('/wx/token/user', 'wxapi\TokenController@getToken');

	Route::any('/wx/login', 'wxapi\AuthenController@toLogin');



	Route::get('/wx/address-list', 'wxapi\MemberController@getList');

	//收货地址管理
	Route::get('/wx/address-list', 'wxapi\MemberController@getList');
	Route::get('/wx/address-details', 'wxapi\MemberController@addrDetails');
	Route::get('/wx/address-save', 'wxapi\MemberController@addrSave');
	Route::post('/wx/address-choose', 'wxapi\MemberController@chooseOrderAddr');  //下单界面选择收货地址


	//分类目录
	Route::get('/wx/category', 'wxapi\CategoryController@getCategoryList');
	Route::get('/wx/goods-category', 'wxapi\CategoryController@getCategoryByParentId');

	//商品相关
	Route::get('/wx/goods-list', 'wxapi\GoodsController@getGoodsList'); //商品列表
	Route::get('/wx/goods-details', 'wxapi\GoodsController@getGoodsDetails'); //商品详情
	Route::get('/wx/goods-fav', 'wxapi\GoodsController@addToCollection'); //商品详情

	//购物车
	Route::post('/wx/cart-add', 'wxapi\CartController@add'); //
	Route::get('/wx/cart-index', 'wxapi\CartController@index'); //购物车列表
	Route::post('/wx/cart-changebuynum', 'wxapi\CartController@changeBuyNum'); //改变购物车商品数量
	Route::post('/wx/cart-checked', 'wxapi\CartController@checked'); //勾选
	Route::post('/wx/cart-delete', 'wxapi\CartController@delete'); //删除购物车商品


	//下单
	Route::get('/wx/order-checkout','wxapi\OrderController@checkOut');//下单前信息确认
	Route::get('/wx/order-checkout1','wxapi\OrderController@checkOut1');//直接购买链接传递
	Route::post('/wx/creat-order','wxapi\OrderController@creatOrder');//下单





	//需要验证登陆
Route::group([ 'middleware' => 'check.login','prefix' => 'admin'],function() {



});