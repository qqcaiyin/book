<?php


namespace  App\Http\Repository;

use App\Entity\Myfav;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_sku;
use App\Entity\Product;

use DB;
class GoodsRepository{

	protected  $product;

	public function __construct( Product $product){
		$this->product = $product;
	}


	//分类商品列表
	public function getGoodsList($where , $page= 1 , $limit =20){

		return  $this->product->where('is_show',1)->whereRaw($where)->offset(($page-1)*$limit)->limit($limit)->get();
	}

	//获取商品详情
	public function getGoodsDetails($goodId = 0){

		return  $this->product->where('id',$goodId)->where('is_show',1)->first()->toarray();
	}


	//获取当前用户的收藏商品状态
	public function userFavStatus($goodId){
		//读取用户ID    假设70
		return Myfav::userFavStatus(70,$goodId);
	}

	//获取商品的sku
	public function  getProductSku($goodId = 0){

		return Pdt_sku:: getProductSku($goodId);
	}

	//获取商品的规格信息
	public function getGoodsSpec($goodId){
		$goodsSpec = Pdt_id_attr::getGoodsSpec($goodId);

		$outData = null;
		if($goodsSpec){
			foreach ($goodsSpec as $key => $value){
				$outData[$value['attr_id']]['name'] = $value['name'];
				$outData[$value['attr_id']]['spec'][$value['id']]= $value['attr_value'];
			}
			$outData = array_values($outData);
		}

		return $outData;
	}

	//获取商品的属性信息
	public function getGoodsAttr($goodId){

	}

}


