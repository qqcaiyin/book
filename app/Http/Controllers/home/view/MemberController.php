<?php

namespace App\Http\Controllers\Home\View;



use App\Entity\City;
use App\Entity\Fav;
use App\Entity\Member_addr;
use App\Entity\Member_log;
use App\Entity\Myfav;
use App\Entity\Order;
use App\Entity\Order_products;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_sku;
use App\Entity\Product;
use App\Entity\Province;
use App\Entity\Visit_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tool\SMS\SendTemplateSMS;
use App\Entity\TempPhone;
use App\Entity\Member;
use App\Entity\TempEmail;
use App\Models\M3Result;
use App\Models\M3Email;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Tool\Validatecode\Code;
use App\Tool\UUID;

use DB;
class MemberController extends commonController
{
	/**
	 * 进入会员中心
	 * @return[type][description]
	 */
	public function toUser(){
		$uid = $this->checkLogin();
		$userInfo  = Member::getUser($uid);
		//被动恢复取消或超时取消的订单库存
		$this->recoverStock($uid);
		//获取会员订单信息
		$myOrder = $this->getMyOrder($uid,4,'');
		//获取浏览记录
		$visit_log = Visit_log::where('member_id',$uid)
					->leftjoin('product','product.id','=','visit_log.product_id')
					->select('product.id','product.name','product.preview','product.price')
					->get()->toarray();
		return view('home/user/user' ,compact('userInfo' , 'myOrder' ,'visit_log') );

	}

	/**
	 * 进入我的订单
	 * @return[type][description]
	 */
	public function toMyOrder(Request $request){
		$data = $request->all();
		$t = isset($data['t'])? intval($data['t']) : 10;
		$uid = $this->checkLogin();

		if($t == 10){
			//被动恢复取消或超时取消的订单库存
			$this->recoverStock($uid);
			//获取会员订单信息
			$myOrder = $this->getMyOrder($uid,5,'');
		}else{
			$where = 'status = '.$t;
			//待支付订单
			$myOrder = $this->getMyOrder($uid,5,$where);

		}

		return view('home/user/myorder' ,compact('myOrder','t'));
	}
	/**
	 * 进入我的订单详情
	 * @param    order_sn 订单号
	 * @return[type][description]
	 */
	public function toMyOrderDetail(Request $request){
		$data = $request->all();
		$oid = isset($data['oid'])? $data['oid'] : 10;
		$uid = $this->checkLogin();

		$where = ' order_sn = '.$oid;
		//订单详情
		$order = $this->getMyOrder($uid,1,$where);
		$orderDetail = $order['orderData'][0];
		$orderDetail['status_shipping'] = explode(',',$orderDetail['status_shipping']);

		return view('home/user/details' ,compact('orderDetail'));
	}
	/**
	 * 进入我的评论
	 * @return
	 */
	public function toMyComment(){
		return view('home/user/mycomment');
	}

	/**
	 * 进入我的收藏
	 * @return[type][description]
	 */
	public function toMyFav(){

		$userId = Session::get('memberId');
		$myFav = Myfav::getMyFav($userId);

		return view('home/user/fav',compact('myFav'));
	}

	/**
	 * 进入我的钱包
	 * @return[type][description]
	 */
	public function toMyMoney(){
		$uid = $this->checkLogin();
		$myMoney  = Member::getUser($uid);
		$myMoneyLog = Member_log::where('member_id',$uid)->where('type',0)->orderby('time','desc')->paginate(15);
		return view('home/user/mymoney' ,compact('myMoney','myMoneyLog'));
	}
	/**
	 * 进入我积分
	 * @return[type][description]
	 */
	public function toMyPoint(){
		$uid = $this->checkLogin();
		$userInfo  = Member::getUser($uid);
		$myPointLog = Member_log::where('member_id',$uid)->where('type',3)->orderby('time','desc')->paginate(15);
		return view('home/user/mypoint'  ,compact('userInfo','myPointLog')    );
	}

	/**
	 * 进入我的地址界面
	 * @return[type][description]
	 */
	public function toMyAddress(){

		$id = Session::get('memberId');
		$data = Member_addr::getAddress($id);
		//地址最大条数 6条
		$count = 1;
		if(count($data)>=6){
			$count = 0;
		}
		return view('home/user/address',compact('data','count'));
	}

	/**
	 * 进入我的地址 添加+修改 界面
	 * 				add_addr  添加
	 * 				edit_addr 修改
	 * @return
	 */
	public function toMyAddressApi(Request $request){

		$data= $request->all();
		$data = $this->inputCheck($data);

		if($data['act'] =='add_addr'){

			$id = Session::get('memberId');
			$data = Province::get()->toarray();

			//给一个表单id，防止重复提交
			Session::put('formId',mt_rand(1000,9999));
			$formId = Session::get('formId');

			return view('home/user/add_addr',compact('data','formId'));

		}else if($data['act'] == 'edit_addr'){

			$id = Session::get('memberId');
			//给一个表单id，防止重复提交
			Session::put('formId',mt_rand(1000,9999));
			$formId = Session::get('formId');

			$province = Province::get()->toarray();
			$city = City::get()->toarray();
			$oldAddr =  Member_addr::find($data['id'])->toarray();

			$editaddr['province'] = $province;
			$editaddr['city'] = $city;
			$editaddr['oldaddr']=$oldAddr;
			$editaddr['oldaddr']['formId']=$formId;

			return view('home/user/edit_addr',compact('editaddr'));




		}

	}


////////////////////////////////////////////////////////////////////

	/**
	 *获取区域：城市下拉菜单
	 * @return[type][description]
	 */
	public function getRegion(Request $request){

		$m3_result = new M3Result;

		$data = $request->all();
		$father = $data['p'];
		$cities = DB::table('hat_city')->where('father',$father)->get();
		if($cities){
			$m3_result->status = 0;
			$m3_result->message = "城市获取成功";
			$m3_result->cities = $cities;
		}
		else{
			$m3_result->status = 10;
			$m3_result->message = "....";
		}
		return $m3_result->toJson();
	}

	/**
	 * 会员中心的各种数据处理操作
	 *
	 * act:   del_fav   	取消收藏
	 * 		  add_fav   	添加收藏
	 * 		  del_addr    	删除地址
	 *        add_address  	添加地址
	 *
	 *
	 * @return
	 */
	public function userApi(Request $request){

		$m3_result = new M3Result;

		$userId = Session::get('memberId');
		if(empty($userId)||!isset($userId) ) {
			$m3_result->status = 20;
			$m3_result->message = "请先登陆";
			return $m3_result->toJson();
		}

		$data =  $request->all();
		$data = $this->inputCheck($data);

		switch($data['act']){
			case 'del_fav':
//取消收藏
				$res = Myfav::where('member_id',$userId)->where('product_id',$data['gid'])->delete();
				if($res){
					$m3_result->status = 0;
					$m3_result->message = "ok";
				}else{
					$m3_result->status = 10;
					$m3_result->message = "取消失败";
				}
				break;
			case 'add_fav':
//添加收藏
				$res =  Myfav::where('member_id',$userId)->where('product_id',$data['gid'])->first();
				if($res){
					$m3_result->status = 10;
					$m3_result->message = "";
					break;
				}
				$res=Myfav::insertGetId([
					'member_id'=>$userId,
					'product_id'=>$data['gid'],
					'time'=>time(),
				]);
				if($res){
					$m3_result->status = 0;
					$m3_result->message = "ok";
				}else{
					$m3_result->status = 10;
					$m3_result->message = "收藏失败";
				}

				break;
			case 'del_addr':
//删除地址
				$res = Member_addr::where('id',$data['gid'])->delete();
				if($res){
					$m3_result->status = 0;
					$m3_result->message = "ok";
				}
				else{

				}
				break;
			case 'add_address':
//添加地址
				$addr = $data['data'];
				if(Session::get('formId')!= $addr['member_id']){
					//表单重复提交
					$m3_result->status = 11;
					$m3_result->message = "不要重复提交表单";
				}else{
					$addr['member_id'] = $userId ;

					if($addr['is_default']==1){
						Member_addr::where('member_id',$userId)->update(['is_default'=>0]);
						$res = Member_addr::insertGetId($addr);
					}else{
						$res = Member_addr::insertGetId($addr);
					}

					if($res){
						Session::put('formId','');
						$m3_result->status = 0;
						$m3_result->message = "ok";
					}else{
						$m3_result->status = 10;
						$m3_result->message = "添加失败";
					}
				}
				break;
			case 'edit_addr':
//编辑地址
				$addr = $data['data'];

				if(Session::get('formId')!= $addr['member_id']){
					//表单重复提交
					$m3_result->status = 11;
					$m3_result->message = "不要重复提交表单";
				}else{
					$addr['member_id'] = $userId ;

					if($addr['is_default']==1){
						Member_addr::where('member_id',$userId)->update(['is_default'=>0]);
						$res = Member_addr::where('id',$data['id'])->update($addr);
					}else{
						$res = Member_addr::where('id',$data['id'])->update($addr);
					}
					if($res){
						Session::put('formId','');
						$m3_result->status = 0;
						$m3_result->message = "ok";
					}else{
						$m3_result->status = 10;
						$m3_result->message = "添加失败";
					}
				}
				break;
			case 'set_paypwd':

				$code = isset($data['code']) ? $data['code'] : 0;
				$paypwd = isset($data['paypwd']) ? $data['paypwd'] : '';
				$repaypwd = isset($data['repaypwd']) ? $data['repaypwd'] : '';

				$userId = $this->checkLogin();
				if(!$userId){
					$m3_result->url = "/login";
					break;
				}

				$user = Member::getUser($userId);
				if(strlen($code) < 6){
					$m3_result->message = "验证码不对";
					break;
				}
				if(strlen($paypwd)!=6 || strlen($repaypwd)!=6 ){
					$m3_result->message = "密码要6位";
					break;
				}
				if($paypwd != $repaypwd){
					$m3_result->message = "两次密码不一致";
					break;
				}

				$res = Member::updateUserInfo( $userId, array('paypwd'=> md5($paypwd)));
				$m3_result->status = 0;
				$m3_result->message = "";

				break;
			case 'del_fav':
				;
				break;
			case 'del_fav':
				;
				break;
			}


			return $m3_result->toJson();
		}






	/**
	 * 用户输入过滤
	 * @return[type][description]
	 */
	protected function inputCheck($data){
		foreach($data as $key =>&$d){
			if(is_array($d)){
				$this->inputCheck($d);
			}else{
				$d = trim($d);
				$d = stripslashes($d);
				$d = htmlspecialchars($d);
			}
		}
		return $data;
	}


}
