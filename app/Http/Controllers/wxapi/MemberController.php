<?php

namespace App\Http\Controllers\Wxapi;

use App\Entity\Member_addr;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Requests\AddrRequest;
use App\Http\Controllers\Controller;
use App\Tool\SMS\SendTemplateSMS;
use App\Entity\TempPhone;
use App\Entity\Member;
use App\Entity\TempEmail;
use App\Models\M3Result;
use App\Models\M3Email;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;

use DB;
class MemberController extends ApiController
{

	protected $jsonRes;
	protected $userRepository;

	public function __construct(UserRepository $userRepository, M3Result $jsonRes)
	{
		$this->userRepository = $userRepository;
		$this->jsonRes = $jsonRes;
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
