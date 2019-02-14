<?php

namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
	public function toCart(Request $request){

		$cart_items =array();

		$bk_cart = $request->cookie('bk_cart');
		$bk_cart_arr = ($bk_cart != null ?  explode(',',$bk_cart) : array());

		$member = $request->session()->get('member','');
		if ($member != ''){
			$cart_items = $this->syncCart($member->id,$bk_cart_arr);
			return response()->view('cart',['cart_items' => $cart_items])->withCookie('bk_cart','');
		}


		foreach ($bk_cart_arr  as $key => $value) {
			$ind = strpos($value, ':');

			$cart_item = new CartItem;
			$cart_item->id = $key;
			$cart_item->product_id = substr($value, 0, $ind);
			$cart_item->count = (int)substr($value, $ind + 1);
			$cart_item->product = Product::find($cart_item->product_id);
			if($cart_item->product !=null){
				array_push($cart_items,$cart_item);
			}
		}

		return view('cart')->with('cart_items',$cart_items);
	}


	public function syncCart($member_id, $bk_cart_arr ){

		$cart_items = CartItem::where('member_id',$member_id)->get();
		//dd($cart_items);
		$cart_items_arr =array();
		//dd($bk_cart_arr);
		foreach ($bk_cart_arr as $value){
			$index = strpos($value, ':');
			$product_id = substr($value, 0, $index);  //当前购物车的产品编号
			$count = (int)substr($value, $index + 1);//当前购物车的产品数量
			//判断离线购物车是否存在数据库中
			$exist = false;
			foreach ($cart_items as $temp){

				if($temp->product_id == $product_id){
					if($temp->count < $count){
						$temp->count = $count;
						$temp->save();
					}
					$exist = true;
					break;}

			}

			//不存在则存起来
			if($exist == false){
				$cart_item = new CartItem;
				$cart_item->member_id = $member_id;
				$cart_item->product_id = $product_id;
				$cart_item->count = $count;
				$cart_item->save();
				$cart_item->product = Product::find($cart_item->product_id);
				array_push($cart_items_arr,$cart_item);
			}
		}
		foreach ($cart_items as $cart_item){
			$cart_item->product = Product::find($cart_item->product_id);
			array_push($cart_items_arr,$cart_item);
		}
		return $cart_items_arr;
	}
}
