<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
	protected $table = 'cart';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段


	/**
	 * 购物车小计
	 *
	 * @return
	 */
	public  static function  getCartTotal($id){

		$cartProducts = Cart::where('member_id',$id)->get();
		$count = 0;//商品总件数
		$type = count($cartProducts);//商品种类
		$total = 0;
		foreach ($cartProducts as $cartProduct){
			$count += $cartProduct->product_num;
			$total += $cartProduct->product_num *$cartProduct->price;
		}

		return array(
			'count'=>$count,
			'type'=>$type,
			'total'=>$total
		);
	}
	/**
	 * 购物车移除产品
	 * @param    $member_id
	 * @param    $product_id  array
	 * @return
	 */
	public static function removePdt($member_id =0,$product_id = 0){
		$num=0;
		$res  = Cart::where('member_id',$member_id)->wherein('product_id',$product_id)->first();
		if($res){
			$num =$res->product_num;
		}
		$res = Cart::where('member_id',$member_id)->wherein('product_id',$product_id)->delete();
		if(!$res ){
			$num = 0;
		}
		return $num;
	}
	/**
	 * 购物车中产品勾选状态更新
	 * @param    $member_id
	 * @param    $product_id  商品id
	 * @param    $status  1 被选中 2 未被选中
	 * @param    $spec  商品规格
	 * @return
	 */
	public static function updateStatus($member_id =0,$product_id = 0,$status = 0 , $spec = ''){
		$res  = Cart::where('member_id',$member_id)->where('product_id',$product_id)->where('spec',$spec)->update(['is_checked'=>$status]);
		return $res;
	}

	//清空购车
	public static function clearCart($uid){
		$res = Cart::where('member_id',$uid)->delete();
		if($res){
			return true;
		}else{
			return false;
		}
	}


}
