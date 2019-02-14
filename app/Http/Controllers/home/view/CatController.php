<?php

namespace App\Http\Controllers\Home\View;

use App\Entity\Category;
use App\Entity\Fav;
use App\Entity\Keywords;
use App\Entity\Myfav;
use App\Entity\Nav;
use App\Entity\Pdt_content;
use App\Entity\Pdt_images;
use App\Entity\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CatController extends CommonController
{
	/**
	 * 商品列表
	 * @return[type][description]
	 */
	public function cateList(Request $request){

		$data = $request->all();
		$id= $data['id'];

		//如果用户登陆了，显示用户收藏的产品
		$userId = Session::get('memberId');
		if(!empty($userId)){
			$myFav = Myfav::getMyFav($userId);
			$myFav = array_column($myFav,'id');
		}

		if($data['at']=='t2'){
			//获取面包屑
			$cateParents = Category::getCatParent($id);
			//查找子分类
			$sonCates = Category::getCatSon($id);

			//查找满足条件的数据
			$where = ' c.path like "%,' .trim($id) . ',%"';
			$products = DB::table('product as p')
				->leftjoin('category as c', 'p.category_id', '=', 'c.id')
				->select('p.*')
				->whereRAW($where)
				->where('is_del', 0)
				->orderby('sort', 'desc')
				->paginate(10);
			$data['cate']=$id;
			return view('home/cat/list' ,compact('cateParents', 'sonCates','products' ,'data' ,'myFav'));
		}else if($data['at']=='t3'){
			$id= $data['cate'];

			$cateParents = Category::getCatParent($id);
			//查找子分类
			$sonCates = Category::getCatSon($id);

			//查找满足条件的数据
			$where = ' c.path like "%,' .trim($data['id']) . ',%"';
			$products = DB::table('product as p')
				->leftjoin('category as c', 'p.category_id', '=', 'c.id')
				->select('p.*')
				->whereRAW($where)
				->where('is_del', 0)
				->orderby('sort', 'desc')
				->paginate(10);

			$t3=1;


			return view('home/cat/list' ,compact('cateParents', 'sonCates','products' ,'data','t3','myFav'));
		}



	}


}
