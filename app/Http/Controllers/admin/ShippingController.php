<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class ShippingController extends Controller
{

////////////////视图界面/////////////////
	/**
	 * 配送方式界面
	 * @return[type][description]
	 */
	public function toShipList()
	{
		$products = Product::where('is_del',0)->orderby('id','desc')->paginate(10);

	//获取每个产品对应的父类列表
$_cate = array();
foreach ($products as $product) {
if ($product->category_id != 0) {
$category = Category::find($product->category_id);
$_cate = explode(',', $category->path);
array_shift($_cate);
array_pop($_cate);
$product->category = Category::whereIn('id', $_cate)->get();
}
}
//获取下拉分类栏
return  view('admin/sys/shipping/ship' ,compact('products','cate'));

	}

	/**
	 * 用户添加界面
	 * @return[type][description]
	 */
	public function toAdminAdd()
	{
		$roles = DB::table('role')->where('is_open',1)->get();
		return view('admin/account/admin/add',compact('roles'));
	}
	/**
	 * 角色编辑界面
	 * @return[type][description]
	 */
	public function toAdminEdit()
	{
		$roles = DB::table('role')->where('is_open',1)->get();
		return view('admin/account/admin/add',compact('roles'));
	}

//////////////////数据处理///////////////////////////////
	/**
	 * 角色添加
	 * @return[type][description]
	 */
	public function adminAdd(Request $request){

		$data = $request->all();
		$name = $data['name'];
		$password = md5($data['password']);
		$reg_time = time();

		//查询数据库是否已经有这个用户名
		$res = DB::table('admin')->where('name',$name)->first();
		if($res){
			//用户名重复 ,返回错误信息，回到添加界面
			return back();
		}
		$id = DB::table('admin')->insertgetid([
			'name'=>$name,
			'password'=>$password,
			'reg_time'=>$reg_time
		]);
		if(!$id){
			//admin 表添加失败
			return back();
		}
		//   如果分配了角色 ，需要添加admin_role 表
		if(isset($data['role_id'])){
			$role_ids = $data['role_id'];
			foreach ($role_ids as $key=> $role_id){
				$temp_data[$key]['admin_id'] = $id;
				$temp_data[$key]['role_id'] = $role_id;
			}
			//批量插入
			$res_num = DB::table('admin_role')->insert($temp_data);
			if($res_num){
				return redirect('/admin/account/admin');
			}else{
				//$m3_result->status = 10;
				//$m3_result->message = "失败";
				return back();
			}
		}
		return redirect('/admin/account/admin');
	}
}
