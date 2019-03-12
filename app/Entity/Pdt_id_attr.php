<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Pdt_id_attr extends Model
{
	protected $table = 'pdt_id_attr';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段

	public static  function  getSpecName($spec){

		$specName = array();
		if(!$spec){
			return null;
		}
		$arrs= explode(',' , $spec);
		foreach ($arrs as $key => $value){
			$res = Pdt_id_attr::where('id',$value)->first();
			if($res){
				$specName[] = $res->attr_value;
			}
		}
		return $specName;
	}


	//获取商品的所有规格
	public  static function  getGoodsSpec($goodId){
		return Pdt_id_attr::where('product_id',$goodId)
							->leftjoin('pdt_attr as pa','attr_id','=','pa.id')
							->where('pa.is_guige',1)
							->select('pdt_id_attr.*','pa.name')
							->get()->toarray();
	}

}
