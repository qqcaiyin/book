<?php

namespace App\Entity;

use App\Exceptions\ApiException;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $table = 'product';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];

	protected $hidden = ['is_del','keywords'];
	//保护字段

	//创建读取器
	public function getPreviewAttribute($value){

		return config('config.img_pre') .$value;
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





	/**
	 * 获取商品信息
	 * @param  product_id	 商品id
	 * @param  spec 		商品规格
	 * @return array
	 */
	public static function getProductsByIdSpec($product_id = 0,  $spec = ''){
		//获取产品详细信息
		$product = Product::where('id',$product_id)->where('is_show',1)
							->select('id','name','preview','price','num')
							->first();
		if(empty($product)){
			throw new ApiException('商品不存在');
		}
		$product = $product->toarray();
		if(!empty($spec)){
			$spec_arr = explode(',',$spec);
			//规格顺序颠倒
			$spec_arr = array_reverse($spec_arr);
			$spec2 = implode(',',$spec_arr);
			//获取产品sku
			$pdt_sku =  Pdt_sku::where('product_id',$product_id)
				->where('sku_attr',$spec)
				->orwhere('sku_attr',$spec2)
				->first()->toarray();
			$specName = Pdt_id_attr::getSpecName($spec);
			if($pdt_sku){
				$product['sku_sn'] = $pdt_sku['sku_sn'];
				$product['price'] = $pdt_sku['sku_price'];
				$product['num'] = $pdt_sku['sku_num'];
				$product['spec'] = $pdt_sku['sku_attr'];
				$product['spec_name'] = $specName;
			}
		}else{
			$product['spec'] = '';
			$product['spec_name'] = '';
		}
		return $product;
	}

	//获取某一款商品库存
	public static function getProductNum($goodId= 0, $spec = ''){
		$storeNum = 0;
		if($spec){
			$res = Pdt_sku::where('product_id',$goodId)->where('sku_attr',$spec)->first();
			if($res){
				$storeNum = $res->sku_num;
			}
		}else{
			$res = Product::where('id',$goodId)->select('num')->first();
			if($res){
				$storeNum = $res->num;
			}
		}
		return $storeNum;
	}









}
