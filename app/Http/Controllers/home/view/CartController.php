<?php

namespace App\Http\Controllers\Home\View;

use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Keywords;
use App\Entity\Nav;
use App\Entity\Order_products;
use App\Entity\Pdt_content;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_images;
use App\Entity\Pdt_sku;
use App\Entity\Product;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends CommonController
{
	/**
	 * 购物车列表
	 * @return[type][description]
	 */
	public function toCart(Request $request){

		$cartList = $this->getCart();
//dd($cartList);
		return  view('home/cart/cart' ,compact('cartList'));
	}

	/**
	 * act :       addtocart 加入购物车
	 *
	 * gid:产品编号
	 *
	 * @return
	 */
	public function serCart(Request $request){

		$m3_result = new M3Result;

		$data = $request->all();
		$userId = Session::get('memberId');
		$act = $data['act'];
		$total = self::$cartPdtNum;
		$spec = isset($data['spec'])?  $data['spec'] : '';

		if($act == 'add_cart'){
		//加入购物车
			$gid = $data['gid'];
			$num = $data['num'];
			$type = isset($data['type'])?$data['type']: 0 ;
			$m3_result->status = 0;
			$m3_result->message ='添加成功';

			if($gid == 0){
				$m3_result->status = 10;
				$m3_result->message = "获取商品编号失败";
				return $m3_result->toJson();
			}
			if($num <= 0){
				$m3_result->status = 10;
				$m3_result->message = "购买数量格式错误";
				return $m3_result->toJson();
			}
			if(($total+1) >100){
				$m3_result->status = 10;
				$m3_result->message = "抱歉您的购物车已满，请先去结账";
				return $m3_result->toJson();
			}
			if(empty($userId) ) {
				//cookie
				$bk_cart = $request->cookie('bk_cart');
				$bk_cart_num = intval( $request->cookie('bk_cart_num'));
				$bk_cart_arr = ($bk_cart != null ?  explode('@',$bk_cart) : array());

				$count = 1;
				foreach ( $bk_cart_arr as &$value){
					$idSpec = $this->getSpec($value);
					if(($idSpec['id'] == $gid) && ($idSpec['spec'] == $spec)){
						$count = (int)$idSpec['num']+$num;
						$pdt_sku =Product:: getProductsNum($gid,$spec);

						if(($num + $count)>$pdt_sku['sku']['sku_num']){
							$m3_result->status = 10;
							$m3_result->message ='库存不足';
							break;
						}
						$value = $gid . '-' . $spec . ':' . $count;
						break;
					}
				}
				if($count == 1){
					array_push($bk_cart_arr,$gid. '-'. $spec . ':' . $num);
				}
				if($m3_result->status == 0 ){
					$m3_result->count = $bk_cart_num;
				}
				$m3_result->count = $total+1;
				return response($m3_result->toJson())->withCookie('bk_cart',implode('@',$bk_cart_arr));
				//return response($m3_result->toJson())->withCookie('bk_cart','');
			}else{
				//mysql
				$flag = 1;
				$count = 1;
				//查找购物车是否已经有相同的产品
				$cartPdt = Cart::where('member_id',$userId)
					->where('product_id',$gid)
					->where('spec',$spec)
					->first();
				if($cartPdt){
					$cartPdt = $cartPdt->toarray();
					$flag = 0;
					$count = $cartPdt['product_num'] +$num;
					$total = $total +$num;
					if($type == 1){
						$count = $num;
						$total = $total -$cartPdt['product_num'] + $num;
					}
				}else{
					$count = $num;
				}

				$cartPdtInfo = Product::getProductsNum( $gid,$spec);
				if($count > $cartPdtInfo['sku']['sku_num']){
					$m3_result->status = 110;
					$m3_result->message ='库存不足';
					$m3_result->test =$cartPdtInfo;
					return $m3_result->toJson();
				}
				if($flag == 1){//购物车不包含此产品
					$res = Cart::insertGetId([
						'product_num'=>$num, 'product_id'=>$gid, 'member_id'=>$userId,'spec'=>$spec,
					]);
					if(!$res){
						$m3_result->status = 10;
						$m3_result->message ='网络异常';
						return $m3_result->toJson();
					}
					$total = $total +$num;
				}else{//购物车已有此产品
					$res = Cart::where('id',$cartPdt['id'])->update(['product_num'=>$count]);
					if(!$res){
						$m3_result->status = 10;
						$m3_result->message ='请刷新页面再试';
						return $m3_result->toJson();
					}
				}
				self::$cartPdtNum =$total;
				$m3_result->count = $total;

				return response($m3_result->toJson())->withCookie('bk_cart','');
			}
		}else if($act == 'remove_products' ){
			$idList = explode('@',$data['gid']);
			$specList = explode('@',$spec);
		//	echo "<pre>";
		//	var_dump($idList);
		//	echo "<pre>";
		//	var_dump($specList);
			//购物车移除商品
			$m3_result->status = 0;
			$m3_result->message ='移除成功';
			if(!empty($userId)){
				//返回删除的产品的数量
				$num = Cart::removePdt($userId,$idList);
				if(!$num){
					$m3_result->status = 10;
					$m3_result->message = "请刷新页面再试";
					return $m3_result->toJson();
				}
				$total =$total- $num;
				self::$cartPdtNum = $total;
				$m3_result->count = $total;
				return response($m3_result->toJson())->withCookie('bk_cart','');
			}else{
				//cookie中移除商品
				$bk_cart = $request->cookie('bk_cart');
				$bk_cart_arr = ($bk_cart != null ?  explode('@',$bk_cart) : array());
				foreach ($bk_cart_arr as $key=> $value){
					$idSpec = $this->getSpec($value);
					foreach ($idList as $k => $id){
						if(($idSpec['id'] == $id) && ($idSpec['spec'] == $specList[$k])) {
							unset($bk_cart_arr[$key]);
							$total = $total - $idSpec['num'];
							break;
						}
					}
				}

				self::$cartPdtNum = $total;
				$m3_result->count = $total;

				return response($m3_result->toJson())->withCookie('bk_cart',implode('@',$bk_cart_arr));
			}
		}else if($act == 'get_cart'){
			$data = $this->getCart();
		//	dd($data);
			$m3_result->status = 0;
			$m3_result->message = "ok";
			$m3_result->data =$data;
			return $m3_result->toJson();
		}else if($act == 'get_cart_status'){
			//更新购物车勾选状态
			$id = intval($data['gid']);
			$status = intval($data['status']);
			$spec = isset($data['spec']) ? $data['spec'] : '';
			if($userId){
				$res = Cart::updateStatus($userId,$id,$status,$spec);
				if(!$res){
					$m3_result->status = 10;
					$m3_result->message = "请刷新页面再试";
					return $m3_result->toJson();
				}
				$m3_result->status = 0;
				$m3_result->message = "ok";
				return $m3_result->toJson();
			}
		}else if($act == 'readd_cart' ){
			//再次购买
			$oid = isset($data['oid'])?  $data['oid'] : '';
			$order_pdts = Order_products::where('order_id',$oid)->get();
			//dd($order_pdts);
			foreach ($order_pdts as $v){
				//查找购物车是否已经有相同的产品
				$cartPdt = Cart::where('member_id',$userId)
					->where('product_id',$v->product_id)
					->where('spec',$v->product_attr)
					->first();
				if($cartPdt){
					// 购物车已经有同款产品
					$num = $cartPdt->product_num +$v->buy_number;
					$res = Cart::where('id' ,$cartPdt->id)->update(['product_num'=>$num]);
				}else{
					// 购物车没有同款产品
					$res = Cart::insertGetId([
						'product_sn' =>$v->product_sn,
						'name' => $v->product_name,
						'price' => $v->product_price,
						'product_num' => $v->buy_number,
						'product_id' => $v->product_id,
						'member_id' =>$userId,
						'spec' => $v->product_attr,
					]);
				}
			}
			return redirect('/cart');
		}else if($act == 'to_order'){
			//库存不足时提示修改购买数量
			$cart_pdts = $this->getCart();
			foreach ($cart_pdts['products'] as $key=> $v){
				if($v['count'] > $v['cart_pdt']['num'] ){
					$m3_result->status = 10;
					$m3_result->message =  $v['cart_pdt']['name'] . '库存还有' . $v['cart_pdt']['num'] . " 件<br>请修改购买数量";
					return $m3_result->toJson();
				}
			}
			$m3_result->status = 0;
			$m3_result->message = "ok";
			$m3_result->data['url'] = "/order";
			return $m3_result->toJson();
		}
	}




}
