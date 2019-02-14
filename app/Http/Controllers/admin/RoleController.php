<?php

namespace App\Http\Controllers\Admin;

use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class RoleController extends Controller
{

////////////////视图界面/////////////////
	/**
	 * 角色列表界面
	 * @return[type][description]
	 */
	public function toRoleList()
	{
		$roles = DB::table('role')->get();
		return view('admin/account/role/list', compact('roles'));
	}

	/**
	 * 角色添加界面
	 * @return[type][description]
	 */
	public function toRoleAdd()
	{
		$nodes = DB::table('node')->where('pid',0)->get();
		foreach ($nodes as  $node){
			$node->childen = DB::table('node')->where('pid',$node->id)->get();
		}
	//	dd($nodes);

		return view('admin/account/role/add',compact('nodes'));
	}
	/**
	 * 角色编辑界面
	 * @return[type][description]
	 */
	public function toRoleEdit($id){

		//
		$role = DB::table('role')->where('id',$id)->first();
		//获取当前角色的权限
		$privillage = DB::table('privillage')->where('role_id',$id)->get();
		//转化为一维数组
		$pri = array_column($privillage,'node_id');
		//获取全部的权限列表 只做 2级
		$nodes = DB::table('node')->where('pid',0)->get();
		foreach ($nodes as  $node){
			$node->childen = DB::table('node')->where('pid',$node->id)->get();
			foreach ($node->childen as $n){
				if(in_array($n->id, $pri )){
					$n->role_node = 1;
				}
				else{
					$n->role_node = 0;
				}
			}
		}
		return view('admin/account/role/edit',compact('role','nodes'));
	}
	/**
	 * 角色添加界面
	 * @return[type][description]
	 */
	public function roleAdd( Request $request)
	{
		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "添加成功";

		$data = $request->all();
		$nodes = $data['node_id'];
		$role = array(
			'name'=>$data['name'],
		);
		//插入新建的角色到角色表 ，并返回对应的id
		$id =  DB::table('role')->insertgetid($role);

		foreach ($nodes as $key=> $node){
			$temp_data[$key]['role_id'] = $id;
			$temp_data[$key]['node_id'] = $node;
		}
		//批量写入 角色- 权限 表
		$res_num = DB::table('privillage')->insert($temp_data);
		//return back();
		if($res_num){
			return redirect('/admin/account/role');
		}else{
			$m3_result->status = 10;
			$m3_result->message = "失败";
			return back();
		}
	}

	/**
	 * list页面开启和禁用角色
	 * @return
	 */
	public function open(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "添加成功";

		$data = $request->all();
		$id = $data['id'];
		$is_open = $data['tp'];
		//更改role表的is_open字段
		$res = DB::table('role')
			->where('id',$id)
			->update(['is_open'=>$is_open]);
		if(!$res){
			$m3_result->status = 10;
			$m3_result->message = "失败";
		}
		return  $m3_result->toJson();
	}
	/**
	 * 删除角色
	 * @return
	 */
	public function roleDel(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "添加成功";
		//获取需要删除的id
		$id = $request->input('id');
		//删除【角色】表对应的数据
		$res = DB::table('role')->where('id',$id)->delete();
		//删除 【角色-管理员】  表对应的数据
		$res = DB::table('admin_role')->where('role_id',$id)->delete();
		//删除 【角色-权限】  表对应的数据
		$res = DB::table('privillage')->where('role_id',$id)->delete();

		return $m3_result->toJson();

	}

	/**
	 * 编辑
	 * @return
	 */
	public function roleEdit(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "添加成功";

		$data = $request->all();
//dd($data);
		$id = $data['id'];
		$name = $data['name'];
		$nodes = $data['node_id'];
		//更新角色表
		//$res =DB::table('role')->where('id',$id)->update(['name'=>$name]);
		//删除当前角色的 privillage 中的原数据
		//$res =DB::table('role')->where('role_id',$id)->delete();

		foreach ($nodes as $key=> $node){
			$temp_data[$key]['role_id'] = $id;
			$temp_data[$key]['node_id'] = $node;
		}
		//此角色的新的权限批量写入 角色- 权限 表
		$res_num = DB::table('privillage')->insert($temp_data);
		//return back();
		if($res_num){
			return redirect('/admin/account/role');
		}else{
			$m3_result->status = 10;
			$m3_result->message = "失败";
			return back();
		}




	}
}
