<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Pdt_sku extends Model
{
	protected $table = 'pdt_sku';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段


	/**
	 * 获取一个商品信息
	 * @param  pdt_id 商品id
	 * @param  spec 商品规格
	 */
	public static function getSkuInfo($pdt_id = 0, $spec = ''){
		$res = Pdt_sku::where('product_id',$pdt_id)->where('sku_attr',$spec)->first()->toarray();
		return $res;
	}

	/**
	 * 获取一个商品信息
	 * @param  id 商品id
	 * @return array
	 */
	public static function getOneProduct($id =0){

		return Product::find($id)->toarray();

	}

	/**
	 * 获取指定商品的有库存的规格
	 * @param  product_id	 商品id
	 * @return array
	 */
	public static function getSkuSpec($pdt_id = 0){
		if($pdt_id){
			$pdt_sku =Pdt_sku::where('product_id',intval($pdt_id))->where('sku_num','>','0')->get()->toarray();
			$spec = '';
			foreach ($pdt_sku as $v  ){
				$spec .= $v['sku_attr'] .',';
			}
			$spec = explode(',',$spec);
		}else{
			$spec = '';
		}
		return $spec ;

	}

	/**
	 * 更新商品库存
	 * @param  spec
	 * @return array
	 */
	public static function updateNum($pdt_id = 0, $spec = '' ,$num = 0){
		$res =0;
		if($pdt_id !=0 && $spec !='' && $num != 0){
			$res = Pdt_sku::where('product_id',$pdt_id)
							->where('sku_attr',$spec)
							->decrement('sku_num',$num);
		}

		return $res;
	}







}
