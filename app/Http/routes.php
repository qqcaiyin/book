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


//Route::any('service/validate_code/create', 'service\ValidateCodeControler@create');
//Route::get('/login', 'View\MemberController@tologin');
//Route::get('/register', 'View\MemberController@register');
//Route::get('/category', 'View\BookController@toCategory');
//Route::post('service/register', 'service\MemberController@register');
//Route::any('service/validate_phone/send', 'service\ValidateCodeControler@sendSMS');

//Route::any('service/validate_email', 'service\ValidateCodeControler@validateEmail');//验证邮箱

//Route::post('service/login', 'service\MemberController@login');//验证登录信息


//////////////////////////////////前台///////////////////////////////////////////////////

	Route::get('/login', 'home\view\LoginController@toLogin');
	Route::get('/register', 'home\view\LoginController@toRegister');

//----------------------会员中心 --------需要login-check中间件--------------------------------------
	Route::get('/user', 'home\view\MemberController@toUser');    //我的会员中心
	Route::get('/myorder', 'home\view\MemberController@toMyOrder');//我的订单
	Route::get('/details', 'home\view\MemberController@toMyOrderDetail');//我的订单

	Route::get('/mycomment', 'home\view\MemberController@toMyComment');  //我的积分页面
	Route::get('/fav', 'home\view\MemberController@toMyFav');  //我的收藏页面
	Route::get('/mymoney', 'home\view\MemberController@toMyMoney');  //我的钱包页面
	Route::get('/mypoint', 'home\view\MemberController@toMyPoint');  //我的积分页面

	Route::get('/address', 'home\view\MemberController@toMyAddress');  //我的地址页面
	Route::get('/address_add', 'home\view\MemberController@toMyAddressApi');  //添加地址



	Route::get('/', 'home\view\IndexController@index');//主页
	Route::get('/cate/', 'home\view\CatController@cateList');
	Route::get('/product/{id}', 'home\view\ProductController@show'); //产品详情页面
	Route::get('/cart', 'home\view\CartController@toCart');//购物车详情页
	Route::get('/order', 'home\view\OrderController@orderInfo');//订单页面


Route::group(['prefix' => 'home' ],function(){
	Route::get('/index', 'home\view\IndexController@index');
	Route::get('/index/js', 'home\view\IndexController@countDown');
	Route::get('/cate/', 'home\view\CatController@cateList');
	//Route::get('/product/show/{id}', 'home\view\ProductController@show');

	Route::get('/cart/add', 'home\view\CartController@addToCart');
	Route::post('/login', 'home\view\LoginController@homelogin');//登陆

	Route::get('/order/addr', 'home\view\OrderController@orderAddr');//添加地址页面
	Route::post('/order/addr_add', 'home\view\OrderController@orderAddrSer');//添加地址

	Route::get('/order/addr/p', 'home\view\OrderController@getRegion');//ajax 请求数据,获取地区
	Route::get('/order/getshipping', 'home\view\OrderController@getShipping');//选择配送方式
	Route::post('/order/action', 'home\view\OrderController@action');//提价订单



});
Route::group(['prefix' => 'service'],function() {
	Route::post('/login', 'home\view\LoginController@homeLogin');//验证登录信息
	Route::get('/out', 'home\view\LoginController@toOut');
	Route::any('/reg', 'service\ValidateCodeControler@userApi'); //注册的处理

	Route::any('/user', 'home\view\MemberController@userApi');
	Route::any('/product', 'home\view\ProductController@serProduct');
	Route::any('/cart', 'home\view\CartController@serCart');
	Route::any('/order', 'home\view\OrderController@serOrder');
});






////////////////////////////////////////////////////////////////////////////////////////
//	Route::get('/login', 'View\MemberController@tologin');
//	Route::get('/register', 'View\MemberController@register');
//	Route::get('/category', 'View\bookController@toCategory');
//	Route::get('/product/category_id/{catefory_id}', 'View\bookController@toProduct');
//	Route::get('/product/{product_id}', 'View\bookController@toPdtContent');

//	Route::get('/cart', 'View\CartController@toCart')->middleware(['check.login']);;
//
Route::group(['prefix' => 'service'],function(){
	Route::any('validate_code/create', 'service\ValidateCodeControler@create');
	Route::any('validate_email', 'service\ValidateCodeControler@validateEmail');//验证邮箱
//	Route::post('login', 'service\MemberController@login');//验证登录信息
	Route::any('validate_phone/send', 'service\ValidateCodeControler@sendSMS');
	Route::get('category/parent_id/{parent_id}', 'service\BookController@getCategoryParentId');
	Route::get('cart/add/{product_id}', 'service\CartController@addCart');
	Route::get('/delete', 'service\CartController@deleteCart');

	//Route::get('/cart', 'View\CartController@toCart');
});


Route::group(['middleware' => 'check.login'],function() {
	Route::get('/order_commit/{product_id}', 'view\OrderController@toCharge');
	Route::get('/order_list/', 'view\OrderController@toOrderList');
});

	Route::post('/service/upload/{type}', 'Service\UploadController@uploadFile');


//后台

	Route::get('/webuploader', 'service\UploadController@webUploader');//测试多图界面
	Route::post('/service/uploadimg', 'service\UploadController@ser');//测试多图上传功能
	Route::post('/product/images', 'service\UploadController@getImages');//测试多图上传功能
	Route::get('/service/product/imgs_del', 'service\UploadController@imagesDel');//多图上传后的删除功能



Route::group([ 'middleware' => 'check.login','prefix' => 'admin'],function() {

	Route::get('/service/login', 'admin\IndexController@login');
//----------------------类别管理------------------------------------------------
	Route::get('/category', 'admin\CategoryController@toCategoryList');
//	Route::get('/category1', 'admin\CategoryController@toCategory1');
	Route::get('/category_add', 'admin\CategoryController@tocategoryAdd');
	Route::get('/category_addson/{id}', 'admin\CategoryController@toCategoryAddson');
	Route::get('/category_edit/{id}', 'admin\CategoryController@tocategoryEdit');

	Route::post('/service/category/add', 'admin\CategoryController@categoryAdd');
	Route::any('/service/category/del', 'admin\CategoryController@categoryDel');
	Route::post('/service/category/edit', 'admin\CategoryController@categoryEdit');
	Route::post('/service/category/changevalue', 'admin\CategoryController@toChangeValue');
//----------------------产品管理------------------------------------------------
	Route::get('/webuploader', 'servi\UpController@webUploader');//测试多图上传功能

	Route::get('/product', 'admin\ProductController@toProductList');
	Route::get('/product/recycle', 'admin\ProductController@toRecycle');
	Route::get('/product_search', 'admin\ProductController@toproductSearch');
	Route::get('/product_add', 'admin\ProductController@toproductAdd');
	Route::get('/product_add/attributes', 'admin\ProductController@toAttributes');
	Route::get('/product_info', 'Admin\ProductController@toproductInfo');
	Route::get('/product_edit', 'admin\ProductController@toproductEdit');
	Route::get('/product_sku', 'admin\ProductController@toProductSku');
    //-------------------------------------------------------------------------------
	Route::post('/service/product/changevalue', 'admin\ProductController@toChangeValue');
	Route::any('/service/product/del', 'admin\ProductController@productDel');
	Route::post('/service/product/add', 'admin\ProductController@productAdd');
	Route::post('/service/product/edit', 'admin\ProductController@productEdit');
	Route::post('/service/product/sku/add', 'admin\ProductController@getSku');
//----------------------产品类型属性管理------------------------------------------------
	Route::get('/type', 'admin\ProductTypeController@toTypeList');
	Route::get('/type_add', 'admin\ProductTypeController@toTypeAdd');
	Route::get('/type_edit/{id}', 'admin\ProductTypeController@toTypeEdit');

	Route::post('/service/type/add', 'admin\ProductTypeController@typeAdd');
	Route::post('/service/type/edit', 'admin\ProductTypeController@typeEdit');
	Route::any('/service/type/del', 'admin\ProductTypeController@typeDel');
//----------------------会员管理------------------------------------------------
	Route::get('/member', 'admin\MemberController@toMember');
	Route::get('/member/member_show/{id}', 'admin\MemberController@memberShow');
	Route::get('/member_add', 'admin\MemberController@toMemberAdd');
	Route::get('/grade', 'admin\MemberController@toMemberGrade');        //会员等级界面
	Route::get('/member_money/{id}', 'admin\MemberController@toMoney');

	Route::post('/service/member/grade', 'admin\MemberController@gradeChangeValue');
	Route::post('/service/member/enable', 'admin\MemberController@memberEnable');
	Route::post('/service/member/del', 'admin\MemberController@memberDel');
	Route::post('/service/member/add', 'admin\MemberController@memberAdd');
	Route::post('/service/member/grade_add', 'admin\MemberController@gradeAdd');//增加等级
	Route::post('/service/member/grade_del', 'admin\MemberController@gradeDel');//删除等级
	Route::post('/service/member/adjust_balance', 'admin\MemberController@adjust_balance');//调整资金
//----------------------余额管理------------------------------------------------
	Route::get('/balance', 'admin\BalanceController@toBalanceList');//余额管理界面
	Route::get('/balance/log_search', 'admin\BalanceController@logSearch');//余额管理  搜索界面

//----------------------管理员管理------------------------------------------------
	//角色
	Route::get('/account/role', 'admin\RoleController@toRoleList');//角色列表界面
	Route::get('/account/role_add', 'admin\RoleController@toRoleAdd');//角色添加界面
	Route::get('/account/role_edit/{id}', 'admin\RoleController@toRoleEdit');//角色编辑界面

	Route::post('/service/account/role/add', 'admin\RoleController@roleAdd');//角色添加
	Route::post('/service/account/role/open', 'admin\RoleController@open');//list的开启禁用按钮
	Route::post('/service/account/role/del', 'admin\RoleController@roleDel');//角色删除
	Route::post('/service/account/role/edit', 'admin\RoleController@roleEdit');//角色编辑
	//管理员
	Route::get('/account/admin', 'admin\AdminController@toAdminList');//管理员列表界面
	Route::get('/account/admin_add', 'admin\AdminController@toAdminAdd');//管理员添加界面
	Route::get('/account/admin_edit', 'admin\AdminController@toAdminEdit');//管理员添加界面

	Route::post('/service/admin/add', 'admin\AdminController@adminAdd');
//----------------------订单管理------------------------------------------------
	Route::get('/order', 'admin\OrderController@toOrderList');//订单列表界面
	Route::get('/order_add', 'admin\OrderController@toOrderAdd');//订单列表界面
	Route::get('/order/info', 'admin\OrderController@toOrderInfo');//订单详情界面
	Route::get('/order/print', 'admin\OrderController@toOrderPrint');//订单打印界面

	Route::get('/service/order/cancel', 'admin\OrderController@orderCancel');//取消订单
	Route::get('/service/order/del', 'admin\OrderController@orderDel');//删除订单
//----------------------配送方式------------------------------------------------
	Route::get('/sys/ship', 'admin\ShippingController@toShipList');//订单列表界面

	//Route::get('/index', function () {
	//	return view('admin.index');
	//});
	Route::get('/index','admin\LoginController@index');
	Route::get('/out','admin\LoginController@out');

	Route::get('excel/export','ExcelController@export');
	Route::get('excel/import','ExcelController@import');

	Route::get('/shield','ShieldController@shield');
	//报错页面
	Route::get('/404','admin\LoginController@error_404');
	//后台主页
	Route::get('/info','admin\LoginController@toInfo');

});
	Route::get('/admin/login', function () {
		return view('admin.login');
	});
	Route::post('/admin/login/check','admin\LoginController@adminlogin');