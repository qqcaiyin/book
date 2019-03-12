<?php

namespace App\Http\Controllers\Wxapi;

use App\Entity\Category;
use App\Entity\Member;
use App\Entity\Member_addr;
use App\Http\Repository\CartRepository;
use App\Http\Repository\OrderRepository;
use App\Http\Requests\AddrRequest;




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



}
