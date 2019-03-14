<?php


namespace  App\Http\Repository;

use App\Entity\Cart;
use App\Entity\Myfav;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_sku;
use App\Entity\Product;

use DB;
class CartRepository{

	protected  $cart;

	public function __construct( Cart $cart){
		$this->cart = $cart;
	}


	//获取购物车列表 $is_checked =1 表示读取购物车中勾选的产品
	public function getCartList($userId = 0,$is_cehecked = 0){

		$list = $this->cart->getCartList($userId);
		$outData = array();
		if($list){
			foreach ($list as $key => $value){
				$outData[$key] = Product::getProductsByIdSpec($value['product_id'] , $value['spec']);
				$outData[$key]['is_checked'] = $value['is_checked'];
				$outData[$key]['buy_num'] = $value['product_num'];
				$outData[$key]['cart_id'] = $value['id'];
			}
		}
		return $outData;
	}

	//更新购物车产品数量
	public function changeBuyNum(  $goodId = 0, $buyNum = 0,$spec = ''){

		//开启事务
		DB::beginTransaction();
		$updateRes = $this->cart->updateGoodBuyNum($goodId,$buyNum,$spec);
		$storeNum =  Product::getProductNum($goodId,$spec);

		if($updateRes &&($storeNum >= $buyNum)){
			DB::commit();
			return array(
				'storeNum'=>$storeNum,
				'status' =>0
			);
		}
		DB::rollBack();
		return array(
			'storeNum'=>$storeNum,
			'status' =>1
		);
	}

	//勾选
	public function checked($where){

		return  $this->cart->checked($where);
	}

	//删除购物车商品
	public function delete($cartId){
		return  $this->cart->where('id',$cartId)->delete();
	}

	//获取购物车产品数量
	public function getCartGoodsNum(){

		$cart = $this->cart->getCartTotal(70);
		return $cart ;

	}


	//添加购物车
	public function  addToCart($data){

		$isHas = $this->checkGoodsExist($data['product_id'],$data['spec']);
		if($isHas){
			$res = $this->changeBuyNum($data['product_id'],$data['product_num']+$isHas->product_num,$data['spec']);
		}else{
			//新添加
			$res = $this->add($data);
		}
		return $res;
	}




	//检测购物车中是否已经存在某商品
	public function checkGoodsExist($goodId = 0,$spec = '' ){

		return $this->cart->where('product_id', $goodId)->where('member_id', 70)->where('spec', $spec)->first();
	}

	//add
	public function add($data){

		$storeNum =  Product::getProductNum($data['product_id'],$data['spec']);
		//开启事务
		DB::beginTransaction();
		$res = $this->cart->insertGetId($data);
		$storeNum =  Product::getProductNum($data['product_id'],$data['spec']);

		if($res &&($storeNum >= $data['product_num'])){
			DB::commit();
			return array(
				'storeNum'=>$storeNum,
				'status' =>0,
			);
		}
		DB::rollBack();
		return array(
			'storeNum'=>$storeNum,
			'status' =>1
		);
	}

	//


}


