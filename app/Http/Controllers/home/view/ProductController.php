<?php

namespace App\Http\Controllers\Home\View;

use App\Entity\Category;
use App\Entity\Keywords;
use App\Entity\Nav;
use App\Entity\Pdt_content;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_images;
use App\Entity\Pdt_sku;
use App\Entity\Product;
use App\Entity\Visit_log;
use App\Models\M3Result;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Home\View\CommonController;

class ProductController extends CommonController
{
	/**
	 * 商品列表
	 * @return[type][description]
	 */
	public function show($id){
		//读取当前登录的用户
		$uid = $this->checkLogin();
		if($uid){
			Visit_log::where('member_id',$uid)->where('product_id',$id)->delete();
			//记录用户浏览记录
			$res = Visit_log::insertGetId(['member_id'=>$uid,'product_id'=>$id,'time'=>time()]);
		}
		$productInfo =  Product::find($id);
		//获取产品图片集
		$productInfo->images = Pdt_images::where('product_id',$productInfo->id)->get();
		//获取产品详情
		$productInfo->content = Pdt_content::where('product_id',$productInfo->id)->first();
		//获取属性和规格列表
		$attr =DB::select( 'select pia.attr_value, pia.attr_id, pia.id,pa.name,pa.is_guige from pdt_id_attr as pia 
							LEFT JOIN pdt_attr as pa  on pia.attr_id=pa.id 
							WHERE product_id='.$id);
		//获取规格的库存
		$spec_arr =Pdt_sku::getSkuSpec($id);

		$attrList=array();
		$specList=array();
		foreach ($attr as $key=> $value ){
			if($value->is_guige){
				$attrList[$value->attr_id]['name'] = $value->name;
				$attrList[$value->attr_id]['spec'][$key]['name'] = $value->attr_value;
				$attrList[$value->attr_id]['spec'][$key]['id'] = $value->id;
				$attrList[$value->attr_id]['spec'][$key]['is_stock'] = in_array($value->id,$spec_arr) ?  1: 0 ;
			}
			else{
				$specList[] = $value;
			}
		}
		//获取面包屑
		$cateParents = Category::getCatParent($productInfo->category_id);

		return view('home/product/show' ,compact('cateParents','productInfo','attrList','specList'));
	}



	public function serProduct(Request $request){
		$data = $request->all();
		$data = $this->inputCheck($data);

		$act = isset($data['act']) ? $data['act'] : '';

		$m3_result = new M3Result;
		$m3_result->status = 10;
		if( $act == 'sku_num'){
			//获取查询规格的库存
			$pdt_id = isset($data['gid']) ? $data['gid']: 0;
			$spec = isset($data['spec']) ? $data['spec'] : '';
			$res = Pdt_sku::getSkuInfo($pdt_id , $spec);
			if($res){
				$m3_result->status = 0;
				$m3_result->data = $res['sku_num'];
			}
			return  $m3_result->toJson();
		}


	}




}
