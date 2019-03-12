<?php

namespace App\Http\Controllers\Wxapi;

use App\Http\Repository\UserRepository;
use App\Http\Requests\AddrRequest;




use DB;
use Illuminate\Http\Request;

class AuthenController extends ApiController
{

	public function __construct()
	{

	}


	/**
	 * 微信小程序用户登录
	 *
	 * @return
	 */
	public function toLogin( Request $request){
		$data = $this->requestCheck($request->all());
		dd($data);


	}





	/**
	 * 获取收货地址列表
	 *
	 * @return
	 */
	public function getList(AddrRequest $request){
		$data = $request->all();
		$userId =  intval($data['id']);
		$addrList = Member_addr::getAddress($userId);
		return $this->respondWithSuccess($addrList);
	}

	/**
	 * 获取收货地址列表
	 *
	 * @return
	 */
	public function addrDetails(AddrRequest $request){
		$data = $request->all();
		$id =  intval($data['id']);
		$addrDetails = Member_addr::getAddrById($id);
		return $this->respondWithSuccess($addrDetails);
	}

	/**
	 * 保存收货地址   包含添加 和 修改地址
	 *
	 * @return
	 */
	public function addrSave(AddrRequest $request){
		$data = $this->requestCheck($request->all()) ;
		$id = $data['id'];
	//	dd($data);
		unset($data['pc']);
		unset($data['id']);

		//开启事务
		DB::beginTransaction();
		try{
			if(intval($data['is_default']) == 1) {
				Member_addr::where('member_id', 70)->where('is_default', 1)->update(['is_default' => 0]);
			}
			if($id){
				Member_addr::where('id',$id)->update($data);
			}else{
				$data['member_id'] = 104;
				Member_addr::create($data);
			}
			DB::commit();
			return $this->success('操作成功');
		}catch(Exception $e){
			DB::rollback();
			return $this->failed('失败');
		}

	}

}
