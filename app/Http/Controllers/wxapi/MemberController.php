<?php

namespace App\Http\Controllers\Wxapi;

use App\Entity\Member_addr;
use App\Exceptions\ApiException;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Requests\AddrRequest;
use App\Http\Controllers\Controller;
use App\Entity\Member;

use Illuminate\Validation\Validator;

use DB;

class MemberController extends ApiController
{

	protected $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}


	/**
	 * 获取收货地址列表
	 *
	 * @return
	 */
	public function getList(AddrRequest $request){
		$data = $request->all();
		//根据token 获取当前用户id
		$uid = $this->userRepository->getCurrentTokenVar($data['token']);
		if(!$uid){
			return $this->failed('token值异常');
		}

		$uid = 70;//测试用
		$addrList = Member_addr::getAddress($uid);
		return $this->respondWithSuccess($addrList);
	}

	/**
	 * 获取收货地址详情
	 *
	 * @return
	 */
	public function addrDetails(AddrRequest $request){
		$data = $request->all();
		//根据token 获取当前用户id
		$uid = $this->userRepository->getCurrentTokenVar($data['token']);

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
		$uid = $this->userRepository->getCurrentTokenVar($data['token']);
		$id = $data['id'];
	//	dd($data);
		unset($data['pc']);
		unset($data['id']);
		unset($data['token']);

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

	//下单界面 选择收件地址
	public function chooseOrderAddr(Request $request){
		$data = $this->requestCheck($request->all());

		//开启事务
		DB::beginTransaction();
		try{
			Member_addr::where('member_id', 70)->update(['is_checked' => 0]);
			Member_addr::where('id',$data['id'])->update(['is_checked' => 1]);
			DB::commit();
			return $this->success('操作成功');
		}catch(Exception $e){
			DB::rollback();
			return $this->failed('失败');
		}
	}

}
