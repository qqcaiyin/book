<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Order;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class SaleCartsController extends Controller
{
	/**
	 * 销售统计
	 * @return
	 */
	public function toSaleTotal(){


		$totalmoney = Order::where('status',8)->sum('products_amount');
		$totalnum = Order::where('status',8)->count();

		$totalSale['money'] = $totalmoney;
		$totalSale['num'] = $totalnum;

		return view('admin/charts/sale_total' ,compact('totalSale'));
	}



	/**
	 * 获取统计图数据
	 * @return[type][description]
	 */
	public function  stat_sale(Request $request){
		$data = $request->all();
		$m3_result = new M3Result;

		$act = isset($data['act']) ? $data['act'] : '';
		if($act == 'get_sale') {
			$year = isset($data['year']) ? $data['year'] : '';
			$month = isset($data['month']) ? $data['month'] : '';
			if ($month == 0) {
				//按照年份来显示  2017-01-01
				for ($i = 1; $i <= 12; $i++) {
					$startTime = $year . '-' . $i . '-1';
					$endTime = $year . '-' . ($i + 1) . '-1';
					$st = strtotime($startTime);
					$et = strtotime($endTime);

					$res = Order::where('status', 8)
						->where('complete_time', '>', $st)
						->where('complete_time', '<', $et)
						->count();

					$m3_result->data['cat'][] = $i;
					$m3_result->data['data'][] = $res;

				}
			} else {
				for ($i = 1; $i <= 31; $i++) {
//按照月份来显示
					$startTime = $year . '-' . $month . '-' .$i .' 0:0:0';
					$endTime = $year . '-' . $month .'-' .($i+1) .' 0:0:0';
					//echo $startTime;
					//echo  "<pre>";
					//echo $endTime ;
				//	exit;


					$st = strtotime($startTime);
					$et = strtotime($endTime);
					$res = Order::where('status', 8)
						->where('complete_time', '>', $st)
						->where('complete_time', '<', $et)
						->count();

					$m3_result->data['cat'][] = $i;
					$m3_result->data['data'][] = $res;
				}


			}
			$m3_result->status = 0;
			return $m3_result->toJson();
		}




	}




////////////////视图界面/////////////////
	/**
	 * 用户列表界面
	 * @return[type][description]
	 */
	public function toAdminList()
	{
		$admins = DB::table('admin')->get();

		return view('admin/account/admin/list', compact('admins'));
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
///
///
///
///
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
