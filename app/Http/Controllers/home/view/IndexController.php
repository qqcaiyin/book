<?php

namespace App\Http\Controllers\Home\View;

use App\Entity\Category;
use App\Entity\Keywords;
use App\Entity\Nav;
use App\Entity\Pdt_content;
use App\Entity\Pdt_images;
use App\Entity\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Redis;

class IndexController extends CommonController
{
	public function index(){
		//	获取热销
		if(Redis::get('hotProducts')){
			$hotProducts = unserialize(Redis::get('hotProducts') ) ;
		}else {
			$hotProducts = Product::select('id', 'name', 'summary', 'price', 'preview')
				->where('is_hot', 1)
				->where('is_del', 0)
				->where('is_show', 1)
				->get()->toarray();
			Redis::set('hotProducts', serialize($hotProducts));
		}
		//处理楼层的分类,以及楼层下【分类】的产品
		if(!Redis::get('allfloors')){
			$allfloors = unserialize(Redis::get('allfloors'));
		}else {
			$allfloors = Category::whereIn('floor',[1,2])->get()->groupby('floor')->toarray();
			Redis::set('allfloors',serialize($allfloors));
		}

		//获取【分类】的子类的类别id
		$products = array();
		if(!Redis::get('products')){
			$products = unserialize( Redis::get('products') ) ;
		}else {
			foreach ($allfloors as $kk => $floors) {
				foreach ($floors as $key => $floor) {
					$cate = Category::select('id')->where('path', 'like', '%,' . $floor['id'] . ',%')->get()->toarray();
					$cate = array_column($cate, 'id');

					$p = Product::select('id', 'name', 'preview', 'price')
						->where('is_del', 0)
						->where('is_show', 1)
						->wherein('category_id', $cate)
						->get()->toarray();
					//$floor->cate = $cate;
					//【分类】下的产品
					//dd($p);
					//$floor->products[]= $p;
					$products[$kk][$key]['name'] = $floor['floor_name'];
					$products[$kk][$key]['product'] = $p;
				}
			}
			Redis::set('products',serialize($products));
		}
		//Log::info('进入书库');

		return view('home/index',compact( 'hotProducts','allfloors','products') );
	}


	public function getFloor($data,$cid){
		static $result = array();


	}

	//倒计时后台
	public function countDown(Request $request){

		$data = $request->all();



		dd($data);
	}

}
