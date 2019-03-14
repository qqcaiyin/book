<?php


namespace  App\Http\Repository;


use App\Entity\Member_addr;
use App\Entity\Order;

use App\Entity\Product;
use App\Exceptions\ApiException;
use DB;
class OrderRepository{

	protected  $order;

	public function __construct( Order $order){
		$this->order = $order;
	}













	//下单后减库存 和 更新销售量
	public function reduceStore($goodId = 0 ,$spec = '',$number = 0 ){
		$res= 0;
		if(!empty($spec)){
			$res1 = Pdt_sku::updateNum($goodId,$spec,$number);
			$res =1;
		}
		$res = Product::updateNum($goodId,$number);
		return   $res;
	}

















	/**
	 * 生成订单号
	 * @return  string
	 */
	public function createOrderSn(){

		$code = array('A','B','C','D','E','F','G','H','I','J','K');
		$date = date('ymd');
		$rand = rand(1000,9999);
		$order_sn =$code[rand(0,10)] . $date . $rand;
		//判断库里是否有相同的订单编号
		$res = DB::table('order_info')->select('order_sn')->where('order_sn',$order_sn)->get();
		if($res){
			$this->createOrderSn();
		}
		return $order_sn;

	}

	/**
	 * 获取下单地址
	 *
	 * @return  array
	 */
	public function getOrderAddress($addressId){

		$orderaddress = Member_addr::find($addressId);
		if(!$orderaddress){
			throw  new ApiException('订单地址异常');
		}
		return $orderaddress->toarray();

	}

	//
	public function  getOrderProductStatus($goodId = 0,$spec = '',$number = 0 ){

		$productInfo = Product::getProductsByIdSpec($goodId ,$spec );
		if($productInfo['num'] < $number){
			throw  new ApiException( $productInfo['name'] . ' 该产品库存不足');
		}
		return $productInfo;
	}





}


