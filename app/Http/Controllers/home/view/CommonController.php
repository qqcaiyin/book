<?php


namespace App\Http\Controllers\Home\View;


use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Keywords;
use App\Entity\Member;
use App\Entity\Member_quan;
use App\Entity\Myfav;
use App\Entity\Nav;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_sku;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\Order_products;
use App\Entity\Quan;
use App\Entity\Quan_issue;
use App\Models\M3Result;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
class CommonController extends Controller
{

	public static  $cartPdtNum='';

	public function __construct(){
		//获取关键词
		$keywords = Keywords::getKeywords();
		//获取nav栏
		$navs = Nav::getNav();
		//获取左菜单
		$categories = Category::getCateList();
		//判断当前是否已登录
		$memberName = Session::get('member') ?: 0;
		//获取购物车信息
		$cartItems = $this->getCart();
//dd($cartItems);
		self::$cartPdtNum = $cartItems['count'];

		View::share('memberName',$memberName);
		View::share('keywords',$keywords);
		View::share('navs',$navs);
		View::share('categories',$categories);
		View::share('cartItems',$cartItems);

	}


	//获取购物车信息
	public function getCart()
	{
		$amount =0;
		$money =0;
		$num =0;
		$result =array();
		$cart_items =array();
		$m3_result = new M3Result;

		$bk_cart = request()->cookie('bk_cart');
		$bk_cart_arr = ($bk_cart != null ?  explode('@',$bk_cart) : array());
		$userid = request()->session()->get('memberId','');
//dd($bk_cart);
		if ($userid != ''){
			//用户登陆的状态下
			$result = $this->syncCart($userid,$bk_cart_arr);
			return $result;
		}
		//id-spec-num
		//1-101，100：2
		foreach ($bk_cart_arr  as $key => $value) {
			$idSpec = $this->getSpec($value);
			$product =Product::getOneProduct($idSpec['id']);
			if($product != null){
				$product = $this->getCartProduct($product,$idSpec['spec'] );
				$cart_item =( ['count'=>$idSpec['num'], 'cart_pdt'=>$product] );
				array_push($cart_items,$cart_item);
				$amount += $product['price'] *$idSpec['num'];

				$num += $idSpec['num'];
			}else{
				return '';
			}
		}
		$result['count'] = $num;
		$result['amount'] = $amount;
		$result['products'] = $cart_items;

		return $result;
	}
//登陆状态， 购物车
	public function syncCart($member_id = 0, $bk_cart_arr=''){

		$num = 0;
		$amount = 0;
		$cart_items_arr = array();
		$result = array();
		$cart_items = Cart::where('member_id',$member_id)->get();
		foreach ($bk_cart_arr as $value){
			$idSpec = $this->getSpec($value);
			$product_id = $idSpec['id'];  //当前购物车的产品对应的编号
			$count = (int)$idSpec['num'];//当前购物车的产品对应的数量
			$spec = $idSpec['spec'];
			//判断离线购物车是否存在数据库中
			$exist = false;
			foreach ($cart_items as $temp){
				if($temp->product_id == $product_id){
					if($temp->product_num < $count){
						$temp->product_num = $count;
						$temp->save();
					}
					$exist = true;
					break;
				}
			}
			//不存在则存起来
			if($exist == false){
				$res = Cart::insertGetId([
					'product_id'=>$product_id,'product_num'=>$count,'member_id'=>$member_id,'spec'=>$spec
				]);
			}
		}
		$cart_items = Cart::where('member_id',$member_id)->get()->toarray();
		foreach ($cart_items as $value){
			$product =Product::getOneProduct($value['product_id']);
			if($product != null){
				$product = $this->getCartProduct($product,$value['spec']);
				$myfav = Myfav::where('member_id',$member_id) ->where('product_id',$value['product_id'])->first();
				if($myfav){
					$fav = 1;
				}else{
					$fav = 0;
				}
				$cart_item =( ['count'=>$value['product_num'], 'is_checked'=>$value['is_checked'], 'myfav'=>$fav,'cart_pdt'=>$product] );
				array_push($cart_items_arr,$cart_item);
				$amount += $product['price'] * $value['product_num'];
				$num += $value['product_num'];
			}else{
				return '';
			}
		}

		$result['count'] = $num;
		$result['amount'] = $amount;
		$result['products'] = $cart_items_arr;

		return $result;
	}

	// 获取购物车 产品的详细信息
	public function getCartProduct($product,$spec=''){
		if(empty($spec)){
			//没有规格
			if($product['is_sale'] == 1 && $product['start_date'] < time() && $product['end_date'] > time()){
				$product['price'] = $product['sale_price'];
			}
			$product['spec'] ='';
		}else {
			// 获取当前产品的 价格、规格名称
			$pdt_sku = Pdt_sku::where('product_id',$product['id'])
				->where('sku_attr',$spec)->first();
			if($pdt_sku){
				$pdt_sku = $pdt_sku->toarray();
				$product['price'] = $pdt_sku['sku_price'];
				$product['spec'] = $pdt_sku['sku_attr'];
				$product['num'] = $pdt_sku['sku_num'];

				$pdt_id_attr = Pdt_id_attr::wherein('id',explode(',',$spec))->get()->toarray();
				foreach ($pdt_id_attr as $value){
					$product['spec_name'][] = $value['attr_value'];
				}
			}else{
				$product['spec'] = '';
			}
		}
		return  $product;
	}
	//  1-101,100:2   获取id 和  spec
	protected  function getSpec($bk=''){
		$result =array();
		if($bk != ''){
			$arr1 = explode('-', $bk);
			$arr2 =  explode(':', $arr1[1]);
			$result['id'] = $arr1[0];
			$result['spec'] = $arr2[0];
			$result['num'] = $arr2[1];
			return $result;
		}
		else{
			return  '';
		}
	}

	//获取用户的订单
	protected  function getMyOrder($uid=0 ,$num = 0 ,$where1= '', $where2 = ''){
		//搜索条件
		$sql = 1;
		if($where1 !=''){
			$sql .= ' and ' . $where1;

		}

		$orderList =Order::orderby('order_info.id','desc')
			->whereRaw($sql)
			->where('is_del',0)
			->where('order_info.member_id',$uid)
			->leftjoin('member' ,'member.id','=','order_info.member_id')		//获取会员信息
			->leftjoin('hat_province as hp' ,'hp.provinceID','=','order_info.province')//获取省份
			->leftjoin('status_desc as sd' ,'sd.status_id','=','order_info.status')//获取订单状态
			->leftjoin('hat_city as hc' ,'hc.cityID','=','order_info.city')			//获取城市
			->select('order_info.*','member.nickname','hp.province','hc.city','sd.status_name','sd.status_desc' ,'sd.status_shipping' ,'sd.next_stepdesc')
			->paginate($num);
//dd($orderList);
		$orderData = array();
		foreach ($orderList as $key=>$order){
			//订单未支付，且超过24小时，取消订单
			if(($order->status == 0) && ((time() - $order->add_time) > (24*3600) )){
				$order->status =1 ;
				$order->status_name ='订单超时';
				$_res = Order::where('id',$order->id)->update(['status'=>1]);
				if($_res){

				}
			}
			//获取订单中的产品列表
			//搜索条件
			$sql = 1;
			if($where2 !=''){
				$sql .= ' and ' . $where2;

			}
			$orderProducts = Order_products::where('order_products.order_id',$order['id'])
				->whereRaw($sql)
				->leftjoin('product' ,'product.id','=','order_products.product_id')		//获取产品信息
				->get()->toarray();

			foreach($orderProducts as &$orderProduct ){
				$attrs = explode(',', $orderProduct['product_attr'] );

				$res = Pdt_id_attr::wherein('id',$attrs)->select('attr_value')->get()->toarray();
				//$orderProduct['spec_name']=implode(',',array_column($res,'attr_value'));
				$orderProduct['spec_name']=array_column($res,'attr_value');
				$comment = Comment::where('order_sn',$order['order_sn'])->where('pdt_id',$orderProduct['product_id'])->first();
				if($comment){
					$orderProduct['comment'] = $comment->content;
					$orderProduct['star_num'] = $comment->star_num;
				}else{
					$orderProduct['comment'] = '';
					$orderProduct['star_num'] = 0;
				}

			}
			$orderData[$key] = $order;
			$orderData[$key]['pdt'] = $orderProducts;
		}

		return  array('orderData'=>$orderData, 'orderList'=>$orderList) ;
	}

	//会员订单超时或者被取消时，被动 恢复库存
	protected function recoverStock($uid = 0){
		//获取会员的取消的订单 1:超时未支付 ，2：手动取消的订单
		$orders = Order::where('member_id',$uid)->where('recovery_stock',0)->whereIn('status',[1,2])->get();

		foreach ($orders as $order){
			//更改订单状态
			$res = Order::where('order_sn',$order->order_sn)->update(['status'=>2,'recovery_stock'=>1]);
			//获取订单下的商品
			$pdt = Order_products::where('order_id',$order->id)->get();
			foreach ($pdt as $v){
				if($v->product_attr != ''){
					$res = Pdt_sku::where('product_id',$v->product_id)->where('sku_attr',$v->product_attr)->increment('sku_num',$v->buy_number);
					$res = Order::where('id',$order->id)->update(['recovery_stock'=>1]);
				}
				$res = Product::where('id',$v->product_id)->increment('num',$v->buy_number);
			}
		}
	}

	function getComments($gid){
		//获取用户评价
		$data = Comment::where('pdt_id', $gid)
			->join('member' ,'member.id' ,'=','comment.member_id')
			->select('comment.*','member.id as uid','member.nickname','member.avatar' )
			->get()->toarray();

		//好评 中评 差评 统计
		$good =0;
		$general = 0;
		$bad = 0;
		foreach ($data as &$v){
			if($v['star_num'] == 1|| $v['star_num'] == 2){
				$bad += 1;
			}else if($v['star_num'] == 3){
				$general +=1;
			}else if($v['star_num'] == 4 || $v['star_num'] == 5){
				$good +=1;
			}
			//
			if($v['spec'] !=''){
				$arrs= explode(',' , $v['spec']);
				foreach ($arrs as $key=>$attr){
					$res = Pdt_id_attr::where('id',$attr)->first();
					$v['spec_name'][] = $res->attr_value;
				}
			}
		}
		$comments['good'] = $good;
		$comments['general'] = $general;
		$comments['bad'] = $bad;
		$comments['sum'] = $bad + $general + $good;
		$comments['good_bfb'] = $comments['sum'] >0 ?  round($good / $comments['sum'] *100  ) :0 ;
		$comments['general_bfb'] = $comments['sum'] >0 ? round($general / $comments['sum'] *100  ):0 ;
		$comments['bad_bfb'] = $comments['sum'] >0 ? round($bad / $comments['sum'] *100  ) : 0 ;
		$comments['data'] =$data;

		return  $comments;
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

	/**
	 * 检测用户是否登陆
	 * @return
	 */
	protected  function  checkLogin(){
		$res = 0;
		$userid = request()->session()->get('memberId','');
		if ($userid != ''){
			$res= $userid;
		}
		return $res;
	}

	//获取物流信息   快递100 接口
	public function  getShipInfo( $order_sn = ''){
		//
		$res = Order::where('order_sn',$order_sn)->first();
		if(!$res){
			return  $res ;
		}
		$post_data['customer'] = '8D8B997D95EEED206987D2A673A0F34C';
		$key = 'DuKvlCyB7218';

		$data = ([
			'com'=>'debangwuliu',
			'num'=>$res->shipping_sn,
		]);
		$post_data['param'] = json_encode($data);
		$url = 'http://poll.kuaidi100.com/poll/query.do';
		$post_data['sign'] = md5($post_data["param"].$key.$post_data["customer"]);
		$post_data["sign"] = strtoupper($post_data["sign"]);
		$o="";
		foreach ($post_data as $k=>$v)
		{
			$o.= "$k=".urlencode($v)."&";		//默认UTF-8编码格式
		}

		$post_data=substr($o,0,-1);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$result = curl_exec($ch);
		$data = str_replace("\"",'"',$result );
		$data = json_decode($data,true);

		return $data;
	}

	//确认收货
	public function orderSign($order_sn =''){
		$res =0;
		if($order_sn != ''){
			$res = Order::where('order_sn', $order_sn)->update(['status'=>6,'shipping_status' =>2 ,'confirm_time'=>time()]);
		}
		return $res;
	}

	//检测用户名是否已存在
	//存在返回 0；
	public function checkNickname($nickname='', $uid= 0){
		$res = 0;
		if($nickname !='' && $uid !=0){
			$res = Member::where('id','!=',$uid)->where('nickname',$nickname)->first();
			if($res){
				$res = 1;
			}else{
				$res = 0;
			}
		}
		return  $res;
	}

	//更新用户个人信息
	public function updateUserInfo($uid = 0, $data ){
		$res = 0;
		if($uid){
			$res = Member::where('id',$uid)->update($data);
			if($res){
				$res = 1;
			}else{
				$res = 0;
			}
		}
		return $res ;
	}

	//更新用户的券，是否过期
	public function updateMyQaun( $uid =0){
		$res = 0;
		if($uid){
			$userQuan = Member_quan::where('member_quan.member_id', $uid)
				->leftjoin('quan','quan.id','=','member_quan.quan_id')
				->leftjoin('quan_issue as qi', 'qi.sn','=','member_quan.quan_sn')
				->where('qi.is_used',0)
				->where('qi.is_overdue',0)
				->select('member_quan.*','quan.*')
				->get()->toarray();

			if( !$userQuan){
				return $res;
			}
			foreach ($userQuan as $v){
				if($v['end_time'] < time()){
					//标记为过期
					$res = Quan_issue::where('quan_id',$v['id'])->update(['is_overdue'=>1]);
					if(!$res){
						break;
						return $res =0;
					}
				}

			}
			return $res =1;
		}




	}






}