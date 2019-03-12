<?php

namespace App\Http\Controllers\Wxapi;

use App\Entity\Category;
use App\Entity\Member_addr;
use App\Http\Repository\CartRepository;
use App\Http\Requests\AddrRequest;




use DB;
use Illuminate\Http\Request;

class CartController extends ApiController
{

	protected $cartRepository;


	public function __construct(CartRepository   $cartRepository ){
		$this->cartRepository = $cartRepository;
	}

	/**
	 * 获取购物车列表
	 * @return
	 */
	public function index( Request $request){

		$cartData = $this->cartRepository->getCartList(70);

			return $this->respondWithSuccess($cartData);
	}

	/**
	 * 修改数量
	 * @return
	 */
	public function  changeBuyNum(Request $request){

		$data = $request->all();

		$storeNum = $this->cartRepository->changeBuyNum(  $data['id'], $data['num']  , $data['spec']);
		if($storeNum){
			return $this->respondWithSuccess($storeNum);
		}
		return $this->failed('失败');
	}

	/**
	 * 购物车产品的勾选
	 * @return
	 */

	public function checked(Request $request){

		$data = $request->all();

		$res = $this->cartRepository->checked($data);
		if($res){
			return $this->success('ok');
		}
		return $this->failed('error');

	}

	/**
	 * 删除购物车产品
	 * @return
	 */
	public function delete(Request $request){
		$data = $this->requestCheck($request->all());
		$res = $this->cartRepository->delete($data['cart_id']);
		if($res){
			return $this->success('ok');
		}
		return $this->failed('error');
	}

	//下单确认
	public function checkOut(Request $request){



	}

	//添加购物车
	public function add(Request $request){

		$data = $request->all();
		$data['member_id'] = 70;
		$res =  $this->cartRepository->addToCart($data);
		if($res['status'] == 0){
			return $this->respondWithSuccess($res,'添加成功' );
		}
		return $this->respondWithSuccess($res,'库存不足' );

	}

}
