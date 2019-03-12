<?php

namespace App\Http\Controllers\Home\View;



use App\Entity\City;
use App\Entity\Comment;
use App\Entity\Comment_msg;
use App\Entity\Fav;
use App\Entity\Member_addr;
use App\Entity\Member_log;
use App\Entity\Member_quan;
use App\Entity\Myfav;
use App\Entity\Order;
use App\Entity\Order_products;
use App\Entity\Order_return;
use App\Entity\Order_return_apply;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_sku;
use App\Entity\Product;
use App\Entity\Province;
use App\Entity\Quan;
use App\Entity\Return_apply_images;
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

		$act = isset($data['act']) ? $data['act'] : '';
		if($act == 'sign'){
			//签收
			$sign_sn = isset($data['oid']) ? $data['oid'] : '';
			$res = $this->orderSign($sign_sn);
		}
		$oid = isset($data['oid'])? $data['oid'] : 10;
		$uid = $this->checkLogin();

		$where = ' order_sn = '.$oid;
		//订单详情
		$order = $this->getMyOrder($uid,1,$where);
		$orderDetail = $order['orderData'][0];
		$orderDetail['status_shipping'] = explode(',',$orderDetail['status_shipping']);
		//获取订单物流
		$shipInfo = $this->getShipInfo($oid);
		return view('home/user/details' ,compact('orderDetail' ,'shipInfo'));
	}

	/**
	 * 进入我的订单的评论界面
	 * @param    order_sn 订单号
	 * @return[type][description]
	 */
	public function toMyOrderComment(Request $request){
		$data = $request->all();
		$oid = isset($data['oid'])? $data['oid'] : 10;
		$uid = $this->checkLogin();

		$where = ' order_sn = '.$oid;
		//订单详情
		$order = $this->getMyOrder($uid,1,$where);
		$orderDetail = $order['orderData'][0];
		$orderDetail['status_shipping'] = explode(',',$orderDetail['status_shipping']);

		return view('home/user/comment' ,compact('orderDetail'));
	}

	/**
	 * 进入我的评论
	 * @return
	 */
	public function toMyComment(){

		$uid = $this->checkLogin();
		//status:8 订单回复完成；
		$where = 'status = 8 ';
		//待支付订单
		$comments = $this->getMyOrder($uid,20,$where);
		return view('home/user/mycomment' ,compact('comments'));
	}

	/**
	 * 进入退换货列表
	 * @return
	 */
	public function toMyService(){

		$uid = $this->checkLogin();
		$applyList = Order_return_apply::where('member_id',$uid)
			->leftjoin('order_products as op' ,'op.order_son_sn','=','order_return_apply.order_sn')
			->select('order_return_apply.*','op.product_id','op.product_name','op.spec_value')
			->get()->toarray();

		return view('home/user/myservice' ,compact('applyList'));
	}

	/**
	 * 进入退换货详情页面
	 * @return
	 */
	public function toServiceDetails(Request $request){
		$data = $request->all();

		$applyList = Order_return_apply::where('order_return_apply.return_sn',$data['sn'])
			->leftjoin('order_products' ,'order_products.order_son_sn','=','order_return_apply.order_sn')
			->leftjoin('product','product.id','=','order_products.product_id')
			->leftjoin('order_return as ot','ot.return_sn','=','order_return_apply.return_sn')
			->select('order_products.*','order_return_apply.*','product.preview' ,'ot.shipping_img')
			->first()->toarray();
		$applydetails = $applyList;
		$img = Return_apply_images::where('return_sn',$data['sn'])->get()->toarray();
		$applydetails['img'] =$img;
		//倒计时，过期未寄回物品， 自动取消
		if($applydetails['status'] ==1){
			$applydetails['days'] = intval((intval($applydetails['audit_time'])+7*24*3600 -time())/(24*3600));
			$applydetails['hours'] = intval( (intval($applydetails['audit_time'])+7*24*3600 -time())%(24*3600)/3600 );
		}
//dd($applydetails);
		return view('home/user/servicedetails' ,compact('applyList','applydetails'));
	}

	/**
	 * 进入退换货详情页面
	 * @return
	 */
	public function toApplyService(Request $request){
		$data = $request->all();
		$uid = $this->checkLogin();
		$where1 = ' order_sn = '. $data['oid'];
		$where2 = ' order_son_sn = ' . $data['son_sn'];
		//订单详情
		$order = $this->getMyOrder($uid,1,$where1,$where2);
		$orderDetail = $order['orderData'][0];

		return view('home/user/applyservice' ,compact('orderDetail' ));

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
	 * 进入我的优惠券
	 * @return[type][description]
	 */
	public function toMyQuan(Request $request){
		$data = $request->all();
		$t = isset($data['t'])? intval($data['t']) : 0;
		//t=1 ,已使用 ；t=2,已过期
//dd($data);
		$where = 1;
		if($t == 1){
			$where .= '  and  qi.is_used=1 ';
		}else if($t == 2){
			$where .= '  and qi.is_overdue=1  and qi.is_used=0    ';
		}else{
			$where .=  '  and qi.is_used=0  and qi.is_overdue=0';
		}
		$userQuan=array();
		$userId = $this->checkLogin();
		if($userId != 0) {
			//更新会员的优惠券是否过期；
			$this->updateMyQaun($userId);
			$userQuan = Member_quan::where('member_quan.member_id', $userId)
				->leftjoin('quan','quan.id','=','member_quan.quan_id')
				->leftjoin('quan_issue as qi', 'qi.sn','=','member_quan.quan_sn')
				->whereRAW($where)
				->select('member_quan.*','quan.*')
				->get()->toarray();
			//dd($userQuan);
		}





		return view('home/user/myquan' ,compact('userQuan','t'));
	}


	/**
	 * 进入个人信息界面
	 * @return
	 */
	public function toUserInfo(){
		$uid = $this->checkLogin();
		$userInfo = Member::getUserInfo($uid);
		return view('home/user/userinfo' ,compact('userInfo') );


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
	 * 进入密码修改，手机更换页面
	 * @return
	 */
	public function toUpdatePwd(){
		$uid = $this->checkLogin();
		$userInfo = Member::getUserInfo($uid);
		return view('home/user/updatepwd' ,compact('userInfo') );


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
		$act = isset($data['act']) ? $data['act'] : '';
		switch($act){
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
//设置密码
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
			case 'comment':
//商品评价
				$anonymous = isset($data['anonymous'])? $data['anonymous'] : 0;//匿名评论
				foreach($data['pdt_id'] as $key=> $v){
					if($data['star'][$key] != '' && $data['content'][$key] != '') {
						$res = Comment::insertGetId([
							'order_sn' => $data['order_sn'],
							'pdt_id' => $data['pdt_id'][$key],
							'spec' => $data['spec'][$key],
							'star_num' =>$data['star'][$key],
							'content' => $data['content'][$key],
							'is_anony' => $anonymous ,
							'member_id' => $userId,
							'time' => time(),
							'member_name'=> !empty(Session::get('member'))? Session::get('member'): '',

						]);
						if (!$res) {
							$m3_result->message = "网络出问题，再次尝试";
						}
					}
				}
				//更新订单表的status 字段
				$res= Order::where('order_sn',$data['order_sn'])->update(['status'=>8]);

				$m3_result->message = "评论成功";
				$m3_result->url = '/detail?oid='. $data['order_sn'];
				return redirect('/details?oid='. $data['order_sn']);
				break;
			case 'add_comment_reply':
//商品评论的回复
				$arr =array();
				$arr['cid'] = isset($data['cid']) ? $data['cid'] : 0;
				$arr['pid'] = isset($data['pid']) ? $data['pid'] : 0;
				$arr['ptype'] = isset($data['ptype']) ? $data['ptype'] : 0;
				$arr['content'] = isset($data['content']) ? $data['content'] : 0;
				$arr['add_time'] = date('Y-m-d H:i:s',time());
				$arr['ip'] = $_SERVER['REMOTE_ADDR']; //获取ip
				$arr['uid'] = $userId;
				$arr['uname'] = !empty(Session::get('member'))? Session::get('member'): '';

				if($data['ptype'] == 0){
					//获取被回复人的 id  name
					$res = Comment::where('id',$arr['cid'])->first();
					if($res ){
						$arr['reply_uid'] = $res->member_id;
						$arr['reply_name'] = $res->member_name;
					}
				}else if($data['ptype'] == 1){
					$res = Comment_msg::where('id' ,$data['cid'])->first();
					if($res ){
						$arr['reply_uid'] = $res->uid;
						$arr['reply_name'] = $res->uname;
					}
				}
				$res = Comment_msg::insertGetId($arr);
				if($res){
					$m3_result->status = 0;
					$m3_result->message = "回复成功";
				}else{
					$m3_result->status = 10;
					$m3_result->message = "回复失败";
				}
				//楼层回复条数更新
				$res = Comment::where('id',$arr['cid'])->increment('comment_msg_num',1);
				if(!$res){
					$m3_result->message = "回复失败";
				}
				break;
			case 'get_comment_reply':
//获取回复
				$cid = isset($data['cid']) ? $data['cid'] : 0;
				$res = Comment_msg::where('cid',$cid)->get()->toarray();
				if($res){
					$m3_result->status = 0;
					//$res['add_time'] = date('Y-m-d H:i:s',$res['add_time']);
					$m3_result->data = $res;
				}
				break;
			case 'return_apply':
//退货申请

				$res = Order_return_apply::where('order_sn',$data['order_sn'])->first();
				if($res){
					$m3_result->status = 10;
					$m3_result->message = "不要重复提交";
					break;
				}
				//存入申请表
				$res = Order_return_apply::insertGetId([
					'order_sn' => $data['order_sn'],
					'return_sn' =>$data['order_sn'],
					'member_id' => $userId,
					'state' =>$data['type'],
					'product_num' =>$data['num'],
					'why' => $data['content'],
					'status' => 0,
					'apply_time' => time(),
				]);
				if($res){
					$m3_result->status = 0;
					$m3_result->message = "申请成功，等待审核";
				}else{
					$m3_result->status = 10;
					$m3_result->message = "刷新页面，重新提交";
					break;
				}
				//存入申请表附属图片表
				foreach($data['img'] as  $key=> $img){
					if($img != ''){
						$res = Return_apply_images::insertGetId([
							'image_path' => $img,
							'image_no' => $key,
							'return_sn' => $data['order_sn'],
						]);
						if(!$res){
							$m3_result->status = 11;
							$m3_result->message = "刷新页面，重新提交";
							break;
						}
					}
				}
				//更新子订单表状态
				$res = Order_products::where('order_son_sn',$data['order_sn'])->update(['status'=>1]);
				break;
			case 'cancel_service':
//取消服务申请
				$sn = isset($data['sn']) ? $data['sn'] : '';
				if($sn == ''){
					$m3_result->status = 10;
					$m3_result->message = "服务单号异常";
					break;
				}
				$res = 	Order_return_apply::where('return_sn',$sn)->update(['status' => 3,'cancel_time' =>time()]);
				if(!$res){
					$m3_result->status = 10;
					$m3_result->message = "刷新页面重新提交";
					break;
				}
				$res = Order_products::where('order_son_sn',$sn)->update(['status' => 0]);
				if(!$res){
					$m3_result->status = 10;
					$m3_result->message = "刷新页面重新提交";
					break;
				}
				$m3_result->status = 0;
				$m3_result->message = "提交成功";

				break;
			case 'edit_userinfo':
//更改个人信息
				$arr=array();

				$nickname = isset($data['username']) ? $data['username'] : '';
				if($nickname ==''  || mb_strlen($nickname) <3){
					$m3_result->status = 10;
					$m3_result->message = "用户名太短";
					break;
				}
				//检测用户名是否也存在
				$res = $this->checkNickname( $nickname ,$userId );
				if($res){
					$m3_result->status = 10;
					$m3_result->message = "用户名已存在";
					break;
				}
				$arr['nickname'] = $nickname;
				if(isset($data['img'])){
					$arr['avatar'] = $data['img'];
				}
				if(isset($data['sex'])){
					$arr['sex'] = $data['sex'];
				}
				if(isset($data['email'])){
					$arr['email'] = $data['email'];
				}
				if(isset($data['birthday'])){
					$arr['birthday'] =  strtotime($data['birthday']);
				}
				if(isset($data['realname'])){
					$arr['realname'] =  $data['realname'];
				}
				$res = $this->updateUserInfo($userId,$arr);

				if($res){
					$m3_result->status = 10;
					$m3_result->message = "用户名已存在";
					break;
				}else{
					$m3_result->status = 0;
					$m3_result->message = "更改成功";
				}
				break;
			case 'return_shipping_sn':
//退货 审核通过  提交快递单
				$arr = array();
				if(isset($data['return_sn'])){
					$arr['return_sn'] = $data['return_sn'];
				}
				if(isset($data['shipping_sn'])){
					$arr['express_sn'] = $data['shipping_sn'];
				}
				if(isset($data['img'])){
					$arr['shipping_img'] = $data['img'];
				}
				$arr['time'] = time();

				//更新状态，买家寄回货物
				$res = Order_return_apply::where('return_sn',$arr['return_sn'])->update(['shipping_status'=>1]);
				if(!$res){
					$m3_result->status = 10;
					$m3_result->message = "请重新提交";
					break;
				}
				$res = Order_return::insertGetId($arr);
				if(!$res){
					$m3_result->status = 10;
					$m3_result->message = "请重新提交";
					break;
				}
				$m3_result->status = 0;
				$m3_result->message = "更改成功";
				break;
			case 'wx_test':
//微信小程序
				$m3_result->status = 0;
				$m3_result->message = "更改成功";
				break;
			}

			return $m3_result->toJson();
		}

	/**
	 * 用户输入过滤
	 * @return
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
