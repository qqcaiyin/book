<?php


namespace App\Http\Controllers\Home\View;


use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Keywords;
use App\Entity\Myfav;
use App\Entity\Nav;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_sku;
use App\Entity\Product;
use App\Entity\Order;
use App\Entity\Order_products;
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
				$pdt_id_attr = Pdt_id_attr::wherein('id',explode(',',$spec))->get()->toarray();
				foreach ($pdt_id_attr as $value){
					$product['spec_name'][] = $value['attr_value'];
				}
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
	protected  function getMyOrder($uid=0 ,$num = 0 ,$where){
		//搜索条件
		$sql = 1;
		if($where !=''){
			$sql .= ' and ' . $where;

		}

		$orderList =Order::orderby('order_info.id','desc')
			->whereRaw($sql)
			->where('is_del',0)
			->where('member_id',$uid)
			->leftjoin('member' ,'member.id','=','order_info.member_id')		//获取会员信息
			->leftjoin('hat_province as hp' ,'hp.provinceID','=','order_info.province')//获取省份
			->leftjoin('status_desc as sd' ,'sd.status_id','=','order_info.status')//获取订单状态
			->leftjoin('hat_city as hc' ,'hc.cityID','=','order_info.city')			//获取城市
			->select('order_info.*','member.nickname','hp.province','hc.city','sd.status_name','sd.status_desc' ,'sd.status_shipping')
			->paginate($num);

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
			$orderProducts = Order_products::where('order_products.order_id',$order['id'])
				->leftjoin('product' ,'product.id','=','order_products.product_id')		//获取产品信息
				->get()->toarray();

			foreach($orderProducts as &$orderProduct ){
				$attrs = explode(',', $orderProduct['product_attr'] );

				$res = Pdt_id_attr::wherein('id',$attrs)->select('attr_value')->get()->toarray();
				$orderProduct['product_attr']=implode(',',array_column($res,'attr_value'));

			}
			$orderData[$key] = $order;
			$orderData[$key]['pdt'] = $orderProducts;
		}

		return  array('orderData'=>$orderData, 'orderList'=>$orderList) ;


	}

	//会员订单超时或者被取消时，被动 恢复库存
	protected function recoverStock($uid = 0){
		//获取会员的取消的订单 1:超时未支付 ，2：手动取消的订单
		$orders = Order::where('member_id',$uid)->where('recovery_stock',0)->where('status',1)->orwhere('status',2)->get();
		//dd($orders);
		foreach ($orders as $order){
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

}