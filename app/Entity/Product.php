<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'product';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段


	public static function getProductInfo($id){



	}

	/**
	 * 获取一个商品信息
	 * @param  id 商品id
	 * @return array
	 */
	public static function getOneProduct($id =0){

		$data = Product::find($id);
		if($data){
			$data = $data->toarray();
		}
		return $data;

	}

	/**
	 * 获取商品库存
	 * @param  product_id	 商品id
	 * @param  spec 		商品规格
	 * @return array
	 */
	public static function getProductsNum($product_id = 0,  $spec =''){
		$result = array();
		//获取产品详细信息
		$product = Product::find($product_id)->toarray();
		if($spec != ''){
			$spec_arr = explode(',',$spec);
			//规格顺序颠倒
			$spec_arr = array_reverse($spec_arr);
			$spec2 = implode(',',$spec_arr);
			//获取产品sku
			$result['sku'] =  Pdt_sku::where('product_id',$product_id)
				->where('sku_attr',$spec)
				->orwhere('sku_attr',$spec2)
				->first()->toarray();
		}else{
			$result['sku']['sku_num'] = $product['num'];
		}
		$result['product']=$product;
		return $result;
	}


	/**
	 * 更新商品库存
	 * @param  spec
	 * @return array
	 */
	public static function updateNum( $pdt_id = 0 ,$num = 0){
		$res =0;
		if($pdt_id !=0 && $num != 0 ){
			$res = Product::where('id',$pdt_id)
				->decrement('num',$num);
			$res = Product::where('id',$pdt_id)
				->increment('salenum',$num);
		}
		return $res;
	}





}
