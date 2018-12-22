<?php

namespace App\Http\Controllers\Service;

use App\Entity\CartItem;
use App\Entity\Category;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
	public function addCart( Request $request,$product_id){

		$bk_cart = $request->cookie('bk_cart');
		$bk_cart_arr = ($bk_cart != null ?  explode(',',$bk_cart) : array());

		$count=1;
		foreach ($bk_cart_arr  as &$value){
			$index = strpos($value,':');
			if(substr($value,0 , $index) == $product_id){
				$count = ((int)substr($value,$index+1))+1;
				$value = $product_id . ':' . $count;
				break;
			}
		}

		if($count == 1){
			array_push($bk_cart_arr,$product_id. ':' . $count);
		}

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = '添加成功';

		return response($m3_result->toJson())->withCookie('bk_cart', implode(',',$bk_cart_arr));
	}

	public function deleteCart(Request $request){
		$m3_reutlt =new M3Result;

		$m3_reutlt->status = 0;
		$m3_reutlt->message = "删除成功";


		$product_ids =$request->input('product_ids','');
		if($product_ids == ''){
			$m3_reutlt->status = 1;
			$m3_reutlt->message = "书籍ID为空";
			return $m3_reutlt->toJson();
		}
		//购物车里需要删除的产品分割成数组
		$request_ids_arr = explode(',' ,$product_ids);

		$member = $request->session()->get('member','');
		if($member != '')
		{
			//此时处于登录状态
			CartItem::whereIN('product_id',$request_ids_arr)->delete();
			return $m3_reutlt->toJson();
		}
		//未登录
		$bk_cart = $request->cookie('bk_cart');
		$bk_cart_arr = ($bk_cart != null ?  explode(',',$bk_cart) : array());
		foreach($bk_cart_arr as $key => $value){
			$index = strpos($value, ':');
			$product_id = substr($value ,0,$index);
			if(in_array($product_id, $request_ids_arr)){
				array_splice($bk_cart_arr, $key,1);
				continue;
			}
		}

		$m3_reutlt->status = 0;
		$m3_reutlt->message = "删除成功";
		return  response($m3_reutlt->toJson())->withCookie('bk_cart', implode(',',$bk_cart_arr));


	}


}
