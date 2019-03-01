<?php

namespace App\Http\Controllers\Home\View;

use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Keywords;
use App\Entity\Member;
use App\Entity\Member_addr;
use App\Entity\Member_log;
use App\Entity\Member_quan;
use App\Entity\Nav;
use App\Entity\Order;
use App\Entity\Order_products;
use App\Entity\Pdt_content;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_images;
use App\Entity\Pdt_sku;
use App\Entity\Product;
use App\Entity\Quan_issue;
use App\Entity\Shipping;
use App\Models\M3Result;
use http\Env\Response;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Tool\SMS\SendTemplateSMS;

use DB;
use App\Http\Controllers\Home\View\CommonController;

class OrderController extends CommonController
{
	/**
	 * 填写地址页面
	 * @return[type][description]
	 */
	public function orderAddr(){
		$id = Session::get('memberid');
		$provinces = DB::table('hat_province')->get();
		return view('home/order/addr',compact('provinces'));
	}

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
	 * 订单页面
	 *
	 * @return
	 */
	public function orderInfo(){

		$m3_result = new M3Result;
		//判断有没有收货人信息
		$id = Session::get('memberId');
		if(!isset($id) ||empty($id)){
			return redirect('/login');
		}
		$user = Member::getUser($id);
		//获取此用户购物车所有产品
		$cart = $this->getCart();
		$cartList =array();
		$amount = 0;
		foreach($cart['products'] as  $key=>$value){
			if($value['is_checked'] == 1){
				$cartList[$key] = $value;
				$sum = $value['cart_pdt']['price'] * $value['count'];
				$cartList[$key]['sum'] = $sum;
				$amount += $sum;
			}
		}
		unset($cart);
		//查找会员默认的收货地址
		$memberAddress = Member_addr::getAddress($id);
		if(!$memberAddress) {
			//填写地址
			return redirect('home/order/addr');
		}
		//查询配送方式
		$shiplist = DB::table('shipping')->where('enabled',1)->get();
		//加上运费的总费用
		$is_default = DB::table('shipping')->where('enabled',1)->where('is_default',1)->first();
		$sumAndShip = $is_default->price + $amount ;
		//订单金额 存到session
		Session::put('products_amount',$amount);

		$id = Session::get('memberId');
		$data = Member_addr::getAddress($id);
		//dd($data);
		//地址最大条数 6条
		$count = 1;
		if(count($data)>=4){
			$count = 0;
		}


		return  Response()->view('home/order/orderinfo',compact('user','cartList','amount','memberAddress','shiplist','sumAndShip' ,'data','count'))->withCookie('orderAddress',$memberAddress);
	}




//////////////////////////////////////////////////////////
	/**
	 * 提交的地址接收
	 * @return[type][description]
	 */
	public function orderAddrSer( Request $request )
	{
		$id = Session::get('memberid');
		echo 'session: id:' . $id;
		//判断是提交过来的表单
		$m3_result = new M3Result;
		$data = $request->except('_token');
		//dd($data);
		$data['province'] = $data['region'][0];
		$data['city'] = isset($data['region'][1]) ? $data['region'][1] : 0;
		$data['member_id'] = $id;
		$data['is_default'] = 1;//设置成默认地址
		unset($data['region']);

		$res = DB::table('member_address')->insertGetId($data);
		if ($res) {
			//成功
			return redirect('home/order');
		}
	}

	/**
	 * 获取用户选择的快递方式
	 * @return[type][description]
	 */
	public function getShipping(Request $request ){

		$m3_result = new M3Result;

		$ship_id =$request->input('ship_id');
		$ship = DB::table('shipping')->select('price')->find($ship_id);
		if($ship){
			$m3_result->status = 0;
			$m3_result->message = '获取成功';
			$m3_result->ship_price = $ship->price;
		}else{
			$m3_result->status = 10;
			$m3_result->message = '获取失败';
		}
		return $m3_result->toJson();
	}


	/**
	 * 订单入库
	 * @return[type][description]
	 */
	public function action(Request $request){

		$m3_result = new M3Result;
		//判断有没有收货人信息
		$memberid = Session::get('memberid');
		//echo 'session: id:' . $id;
		if(!isset($memberid) ||empty($memberid)){
			$m3_result->status = 20;
			$m3_result->message = "请先登陆";
			return $m3_result->toJson();
		}
		//判断是否已经下过单，购物车是否已清空
		$res = Cart::where('member_id',$memberid)->exists();
		if(!$res){
			$msg['status'] = 10;
			$msg['msg'] = "订单已完成";
			return  view('home/order/orderaction',compact('msg'));
		}
		//读取传递过来的表单值
		$data = $request->all();
		$orderInfo['member_id'] = $memberid;          //会员ID
		$orderInfo['order_sn'] = $this->orderCreateSn();//获取订单编号
		//获取cookie保存的收货地址
		$orderAddress = $request->cookie('orderAddress');
		$orderInfo['consignee'] = $orderAddress->consignee;     //收货人姓名
		$orderInfo['moble'] = $orderAddress->moble;				//收货人号码
		$orderInfo['province'] = $orderAddress->province->id;	//收货人地址：省份
		$orderInfo['city'] = $orderAddress->city->id;			//收货人地址：城市
		$orderInfo['address'] = $orderAddress->district;		//收货人地址：详细地址
		$orderInfo['zipcode'] = $orderAddress->zipcode;			//收货人地址：邮编
		//获取配送信息
		$shipId = $data['shipping'][0];
		$shipping = DB::table('shipping')->select('id','name','price')->find($shipId);
		$orderInfo['shipping_id'] = $shipping->id;   //配送方式
		$orderInfo['shipping_name'] = $shipping->name; //配送名称
		$orderInfo['shipping_fee'] = $shipping->price; //配送价格
		//获取支付方式
		$orderInfo['pay_name'] = $data['pay_name'];   //支付方式
		$orderInfo['add_time'] = time();              //订单添加时间
		$orderInfo['products_amount'] =Session::get('products_amount'); //商品总价格
		//使用余额或红包   （暂时不算）
		$orderInfo['order_amount'] = $orderInfo['products_amount'] + $orderInfo['shipping_fee'] ;

		//订单入库，返回插入的ID
		$res = DB::table('order_info')->insertGetId($orderInfo);
		if($res){
			$m3_result->status = 0;
			$m3_result->message = "订单添加成功";
		}else{
			$msg['status'] = 10;
			$msg['msg'] = "订单商品信息添加失败";
			return  view('home/order/orderaction',compact('msg'));
		}
		//获取订单中商品信息的商品
		$cartList = Cart::where('member_id',$memberid)
			->join('product as p', 'p.id','=','cart.product_id' )
			->select('p.id as product_id','p.name as product_name' ,'p.product_sn','cart.price as product_price','cart.product_num as buy_number','cart.spec as product_attr')
			->get()->toArray();
		//订单中商品详细信入库
		foreach ($cartList as $value ){
			$value['order_id'] = $res;
			$result = DB::table('order_products')->insertGetId($value);
			if(!$result){
				$m3_result->status = 10;
				$m3_result->message = "订单商品信息添加失败";
				$msg['status'] = 10;
				$msg['msg'] = "订单商品信息添加失败";
				return  view('home/order/orderaction',compact('msg'));
			}
		}
		//下单成功,清空购物车
		Cart::clearCart();

		$msg['status'] = 0;
		$msg['order_sn'] = $orderInfo['order_sn'];
		$msg['ship_name'] = $orderInfo['shipping_name'];
		$msg['pay_name'] = $orderInfo['pay_name'];
		$msg['order_amount'] = $orderInfo['order_amount'] ;

		return  view('home/order/orderaction',compact('msg'));
	}

	/**
	 * 生成订单号
	 * @return  string
	 */
	protected function orderCreateSn(){
		$date = date('ymd');
		$rand = rand(1000,9999);
		$order_sn = $date . $rand;
		//判断库里是否有相同的订单编号
		$res = DB::table('order_info')->select('order_sn')->where('order_sn',$order_sn)->get();
		if($res){
			$this->orderCreateSn();
		}
		return $order_sn;

	}

	//订单处理
	public function serOrder(Request $request){
		$m3_result = new M3Result;
		$m3_result->status = 10;
		$user_id = 0;

		$data = $this->inputCheck($request->all());
		$act = isset($data['act'])? $data['act']:'';
		if($act == 'add_order'){
//添加订单
			$user_id = $this->checkLogin();
			if($user_id == 0){
				//用户需要登陆
				$m3_result->status = 20;
				$m3_result->message='请先登录';
				return $m3_result->toJson();
			}
			$cneeid = isset($data['cneeid'])? intval($data['cneeid']) : 0;
			$shipid = isset($data['shipid'])? intval($data['shipid']) : 0;
			$balance = isset($data['balance'])? abs(floatval($data['balance'])) : 0;
			$parvalue = isset($data['parvalue'])? abs(floatval($data['parvalue'])) : 0;
			$point = isset($data['point'])? abs(intval($data['point'])) : 0;
			$quan_sn = isset($data['quan_sn'])? $data['quan_sn'] : '';
			$paypwd = isset($data['paypwd'])? $data['paypwd'] : '';
			$message = isset($data['user_msg'])? $data['user_msg'] : '';

			//判断优惠券是否过期
			$this->updateMyQaun();
			$res =Member_quan::getQuanState($user_id,$quan_sn);
			if(!$res){
				$m3_result->message='当前优惠券不能使用';
				return $m3_result->toJson();
			}
			$qid = $res['quan_id'];
			//获取此用户购物车所有产品
			$cart = $this->getCart();
			$cartList =array();
			$amount = 0;
			$update_num = array();

			foreach($cart['products'] as  $key=>$v){
				if($v['is_checked'] == 1){
					if($v['cart_pdt']['is_show'] == 0){
						$m3_result->message='商品【 '.$v['cart_pdt']['name'] .' 】已经下架';
						return $m3_result->toJson();
					}
					if($v['count'] > $v['cart_pdt']['num']){
						$m3_result->message ='库存不足，商品<br>【 ' .$v['cart_pdt']['name'] . ' 】<br>库存只有' . $v['cart_pdt']['num']  . '件'    ;
						return $m3_result->toJson();
					}

					if(  $v['cart_pdt']['spec'] !== ''){
						$update_num[$key]['spec'] = $v['cart_pdt']['spec'];
					}else{
						$update_num[$key]['spec'] = '';
					}
					$update_num[$key]['pdt_id'] = $v['cart_pdt']['id'];
					$update_num[$key]['num'] = intval($v['count']); //更新库存
					$update_num[$key]['salenum'] = intval($v['count']) ;//更新销售数量

					$cartList[$key] = $v;
					$sum = $v['cart_pdt']['price'] * $v['count'];
					$cartList[$key]['sum'] = $sum;
					$amount += $sum;
				}
			}
			unset($cart);

			if(!count($cartList) ){
				$m3_result->message='您的购物车还没有商品，请刷新重试';
				return $m3_result->toJson();
			}
			$user = Member::getUser($user_id);
			$consignee = Member_addr::getOneAddress($user_id,$cneeid );
			$shipping =Shipping::getShipping($shipid);
			if(!$consignee){
				$m3_result->message='请先填写收件地址';
				return $m3_result->toJson();
			}

			if($balance >0 || $point >0){
				$paypwd_err_count = intval(Session::get('paypwd_err_count'));
				if($paypwd_err_count !=null && $paypwd_err_count >=5){
					$m3_result->message="您已经输错3次密码，密码锁死<br> 请去个人中心修改";
					return $m3_result->toJson();
				}else if($paypwd == ''){
					$m3_result->message='使用余额于积分支付，需要填写支付密码';
					return $m3_result->toJson();
				}else if(md5($paypwd) != $user['paypwd']){
					Session::put('paypwd_err_count',$paypwd_err_count+1);
					$m3_result->message='支付密码不正确';
					return $m3_result->toJson();
				}
			}

			$pay_amount = $balance + $point/100 + $parvalue  ;       //使用余额和积分等支付的金额
			$order_amount = $amount + $shipping['price'];
			$data = array(
				'order_sn' => $this->orderCreateSn(),//获取订单编号
				'member_id' => $user_id, //用户id
				'products_amount' => $amount ,//应付总金额
				'order_amount' => $order_amount, //订单金额
				'money_paid' => $pay_amount,  //已支付金额
				'quan_amount' =>$parvalue,
				'balance_amount' => $balance , //余额支付的部分
				'point_amount' => $point/100,  //积分支付的部分
				'message' => $message, 					//订单留言
				'consignee' => $consignee['consignee'],	//收件地址
				'moble' => $consignee['moble'],
				'province' => $consignee['province'],
				'city' => $consignee['city'],
				'address' => $consignee['district'],
				'zipcode' => $consignee['zipcode'],
				'shipping_id' => $shipping['id'],		//快递方式
				'shipping_name'=> $shipping['name'],
				'shipping_fee' => $shipping['price'],
				'add_time' => time(),					//生成订单时间
				'order_status' => 0,    //订单状态
				'shipping_status' => 0,	//未发货
				'pay_status' => 0,   //未支付
				'status' => 0 ,    //对应status_desc 表    待支付
			);
			if($user['openbalance'] < $balance){
				$m3_result->message="余额不足";
				return $m3_result->toJson();
			}

			if($pay_amount >= $order_amount){
				//余额和积分完成了支付  ，设置状态为已支付
				$data['status'] = 4;
				$data['pay_status'] =1;
				$data['pay_id'] = 0;
				$data['pay_time'] = time();
			}

			//开启事务
			DB::beginTransaction();

			//写入订单表  -
			$order_id = Order::insertGetId($data);
			if(!$order_id){
				DB::rollBack();
				$m3_result->message="网络异常，请刷新页面，重新提交";
				return $m3_result->toJson();
			}
			//写入订单对应的产品
			foreach ($cartList as $v){
				$order_pdt = array(
					'order_id' => $order_id,
					'product_id' => $v['cart_pdt']['id'],
					'product_name' => $v['cart_pdt']['name'],
					'product_sn' => $v['cart_pdt']['product_sn'],
					'buy_number' => $v['count'],
					'product_price' => $v['cart_pdt']['price'],
					'product_attr' => $v['cart_pdt']['spec'],
				);
				$res = Order_products::insertGetId($order_pdt);
				if(!$res){
					DB::rollBack();
					$m3_result->message="网络异常，请刷新页面，重新提交";
					return $m3_result->toJson();
				}

			}
			//减少库存 和 更新销售量
			foreach($update_num as $v){
				if($v['spec'] != ''){
					Pdt_sku::updateNum($v['pdt_id'],$v['spec'],$v['num']);
				}
				Product::updateNum($v['pdt_id'],$v['num']);
			}
			//更新余额
			if($balance > 0){
				 Member::updateUserInfo($user_id,array( 'openbalance'=>($user['openbalance']-$balance) ) );
				 Member_log::insertUserLog( array(  'member_id'=>$user_id, 'type'=>0, 'pm'=>0, 'num'=>$balance ,
					 'time'=>time(), 'desc' =>'订单'.$data['order_sn'].' 使用余额'.$data['balance_amount']  ) );
			}
			//更新积分
			if($point > 0){
				Member::updateUserInfo($user_id,array( 'point'=>($user['point']-$point) ) );
				Member_log::insertUserLog( array(  'member_id'=>$user_id, 'type'=>3, 'pm'=>0, 'num'=>$point ,
					'time'=>time(), 'desc' =>'订单'.$data['order_sn'].' 使用积分'.$point  ) );
			}
			if($pay_amount >= $order_amount){
				//支付完成  发送信息给用户
				$moble = $consignee['moble'];
				$sendTemp = new SendTemplateSMS;
				$order_sn='order:'.$data['order_sn'];
				$m3_result = $sendTemp->sendTemplateSMS($moble,array($order_sn,60),1);
			}
			//下单成功,清空购物车
			Cart::clearCart($user_id);
			//更新优惠券状态
			$resQuan = Member_quan::updateQuanState($user_id,$qid,$quan_sn);
			if($resQuan){
				DB::commit();
				$m3_result->status = 0;
				$m3_result->message = "订单完成";
				return $m3_result->toJson();
			}else{
				DB::rollBack();
				$m3_result->message="网络异常，请刷新页面，重新提交";
				return $m3_result->toJson();
			}

		}
		if($act == 'order_cancel'){
			//取消订单
			$order_sn = isset($data['order_sn']) ? $data['order_sn'] : '';
			$oid = isset($data['oid']) ? $data['oid'] : 0;
			//更改订单状态
			$res = Order::where('order_sn',$order_sn)->update(['status'=>2,'recovery_stock'=>1]);
			if($res){
				//取消订单后，库存恢复，
				$pdt = Order_products::where('order_id',$oid)->get();
				foreach ($pdt as $v){
					if($v->product_attr != ''){
						$res = Pdt_sku::where('product_id',$v->product_id)->where('sku_attr',$v->product_attr)->increment('sku_num',$v->buy_number);
					}
					$res = Product::where('id',$v->product_id)->increment('num',$v->buy_number);
				}
				$m3_result->status = 0;
				$m3_result->message = '订单取消成功';
			}else{
				$m3_result->status = 10;
				$m3_result->message = '订单取消失败';
			}
			return $m3_result->toJson();
		}else if($act == 'get_myquan'){
//获取我的当前订单可用的优惠券
			//dd($data);
			//获取优惠券需要先登陆
			$uid = $this->checkLogin();
			if($uid == 0){
				$m3_result->status = 20;
				$m3_result->message='请先登录';
				return $m3_result->toJson();
			}
			//获取订单总价和产品id
			$amount = isset($data['amount']) ? intval($data['amount']) : 0;
			$good_ids = isset($data['good_ids']) ? trim($data['good_ids']) :'';
			$gids = explode(',',$good_ids);

			$where = 1;
			$where .=  '  and qi.is_used=0  and qi.is_overdue=0 and quan.amount_reached <=' . $amount;

			$this->updateMyQaun($uid);
			$userQuan = Member_quan::getUserQuan($uid,$where);
			if($userQuan){
				$m3_result->status = 0;
				$m3_result->message='ok';
				$m3_result->data=$userQuan;
				return $m3_result->toJson();
			}else{
				$m3_result->status = 20;
				$m3_result->message='获取失败';
				return $m3_result->toJson();
			}





		}
	}

}
/*
$data =[
	[
		'id' =>1,
		'name'=>'红',
		'prop'=>[
			'pid' =>1,
			'pname'=>'颜色'
		]],
	[
		'id' =>2,
		'name'=>'黄',
		'prop'=>[
			'pid' =>1,
			'pname'=>'颜色'
		]],
	[
		'id' =>3,
		'name'=>'大',
		'prop'=>[
			'pid' =>2,
			'pname'=>'尺寸'
		]],

];

//	dd($data);
$arr= array();
foreach($data   as $key => $v){

	$arr[$v['prop']['pid']]['pid'] = $v['prop']['pid'];
	$arr[$v['prop']['pid']]['pname'] = $v['prop']['pname'];
	$arr[$v['prop']['pid']]['list'][$key]['id'] = $v['id'];
	$arr[$v['prop']['pid']]['list'][$key]['name'] = $v['name'];

}



dd($arr);
*/