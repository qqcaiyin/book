<?php

namespace App\Http\Controllers\Wxapi;

use App\Entity\Category;
use App\Entity\Member;
use App\Entity\Member_addr;
use App\Entity\Order;
use App\Entity\Order_products;
use App\Entity\Product;
use App\Exceptions\ApiException;
use App\Http\Repository\CartRepository;
use App\Http\Repository\OrderRepository;
use App\Http\Requests\AddrRequest;


use App\Http\Requests\BuyNowRequest;
use DB;
use Illuminate\Http\Request;

class OrderController extends ApiController
{

	protected $orderRepository;
	protected $cartRepository;

	public function __construct(OrderRepository   $orderRepository , CartRepository $cartRepository ){
		$this->orderRepository = $orderRepository;
		$this->cartRepository = $cartRepository;
	}

	/**
	 * 订单确认界面
	 * @return
	 */
	public function checkOut( Request $request){

		//$res = Member:: find(70)->address()->where('is_checked',1)->first()->toarray();

		$outData = array();
		$defaultAddress = Member_addr::getAddress(70,1);//获取默认的收件地址
		if($defaultAddress){
			$outData['address'] = $defaultAddress[0];
		}else{
			$outData['address'] = '';
		}

		$cartList = $this->cartRepository->getCartList(70);

		$amount = 0;
		foreach ( $cartList as &$value){
			if($value['is_checked']==1){
				$amount += $value['price'] * $value['buy_num'];
				$outData['goods'][]= $value;
			}

		}
		$outData['amount'] = $amount;
		return $this->respondWithSuccess($outData);
	}

	//
	public function checkOut1(BuyNowRequest $request){

		$data = $request->all();
		$outData = array();
		$defaultAddress = Member_addr::getAddress(70,1);//获取默认的收件地址
		if($defaultAddress){
			$outData['address'] = $defaultAddress[0];
		}else{
			$outData['address'] = '';
		}
		//获取产品
		$goodInfo =  Product::  getProductsByIdSpec($data['id'],$data['spec']) ;
		if(!$goodInfo){
			throw new ApiException("产品不存在");
		}

		$goodInfo['buy_num'] = $data['number'];
		$outData['goods'][] = $goodInfo;
		$outData['amount'] = intval($data['number']) *$goodInfo['price'] ;

		return $this->respondWithSuccess($outData);
	}


	//生成订单
	public function creatOrder(BuyNowRequest $request){

		$data = $this->requestCheck($request->all());

		$order =array();
		$product = array();
		//获取订单里产品的信息
		$pdt = $this->orderRepository->getOrderProductStatus($data['id'],$data['spec'],$data['number']);
		$product['product_id'] = $pdt['id'];
		$product['product_name'] = $pdt['name'];
		$product['buy_number'] = $data['number'];
		$product['product_price'] = $pdt['price'];
		$product['product_attr'] = $pdt['spec'];
		$product['spec_value'] = $pdt['spec_name'];
		//订单填充信息
		$orderaddress = $this->orderRepository->getOrderAddress($data['addressId']); //获取订单收件地址
		$order['consignee'] = $orderaddress['consignee'];
		$order['moble'] = $orderaddress['moble'];
		$order['province'] = $orderaddress['province'];
		$order['city'] = $orderaddress['city'];
		$order['address'] = $orderaddress['district'];
		$order['add_time'] = time();

		$order['order_sn'] = $this->orderRepository->createOrderSn();
		$order['member_id'] = 70;

		//开启事务
		DB::beginTransaction();
			//写入订单表
			$orderId = Order::insertGetId($order);
			$product['order_id'] = $orderId;
			//写入订单的产品表
			$res =  Order_products::insertGetId($product);
			//修改库存
			$res2 = $this->orderRepository->reduceStore($data['id'] , $data['spec'] ,  $data['number']);
			if($orderId && $res && $res2){
				DB::commit();
				return  $this ->success('下单成功');
			}
		DB::rollBack();
		return  $this->failed('下单失败');
	}


	/**下单
	 * 1.检查订单中商品库存，
	 * 2.库存足够，下单成功，库存扣除
	 * 3.支付接口
	 * 4.未支付 定时1小时 ，未支付订单取消，恢复库存
	 **/
	public function  placeOrder(){




	}






	//生成订单快照
	public function snapOrder( ){

		$snap = [
			'orderPrice' =>0,
			'totalCount' =>0,
			'snapAddress' => null,
			'snapName' => '',
			'snapImg' => '',
		];


	}

	//



}
