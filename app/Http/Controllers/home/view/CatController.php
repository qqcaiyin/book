<?php

namespace App\Http\Controllers\Home\View;

use App\Entity\Category;
use App\Entity\Fav;
use App\Entity\Keywords;
use App\Entity\Member_quan;
use App\Entity\Myfav;
use App\Entity\Nav;
use App\Entity\Pdt_content;
use App\Entity\Pdt_images;
use App\Entity\Product;
use App\Entity\Quan;
use App\Entity\Quan_issue;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CatController extends CommonController
{

	/**
	 * 优惠券列表
	 * @return
	 */
	public function toQuan(){
		//获取全部可领取的优惠券列表
		$quanList = Quan::orderby('sort','desc' )
			->where('is_enable',1)
			->where('nostock',0)
			->get()->toarray();
		//获取当前用户的已领取优惠券
		//领券需要先登陆
		$userQuanId=array();
		$userId = $this->checkLogin();
		if($userId != 0){
			//用户登陆
		//	$userQuan = Member_quan::select( DB::raw(  '  member_quan.quan_id , count(*) as total    '  ) )
			$userQuan = Member_quan::where('member_id',$userId)
						->groupby('quan_id')
						->get()->toarray();
			$userQuanId = array_column($userQuan,'quan_id');
		}
		return view('home/quan/quan' ,compact('quanList' ,'userQuanId'));
	}






	/**
	 * 商品列表
	 * @return[type][description]
	 */
	public function cateList(Request $request){
		$data = $request->all();

		$act =  isset($data['at']) ? $data['at'] : 0 ;
		$where = 1;
		if($act == 'search'){
			$tp = isset($data['n']) ? trim($data['n']) : '';
			$word = isset($data['words']) ? trim($data['words']) : '';
			$wordlist=str_replace("+",",",$word);
			$wordlist=str_replace(" ",",",$wordlist);
			$wordlistx=explode(',',$wordlist);
			$where .=" and ( ";
			$keyworksqland='';
			for ($k=0;$k<count($wordlistx);$k++){
				if ($k>0  ){
					$keyworksqland=" and ";
				}
				if ( $wordlistx[$k] !='' ){
					$where .=$keyworksqland."  p.name like '%".addslashes($wordlistx[$k])."%'";
				}
			}
			$where .=" ) ";
			if($tp == 'saleup' ){
				$where .= 'order by salenum  asc ';
			}else if($tp == 'saledown' ){
				$where .= 'order by salenum  desc ';
			}else if($tp == 'priceup' ){
				$where .= 'order by price  asc ';
			}else if($tp == 'pricedown' ){
				$where .= 'order  by price  desc ';
			}
			$products = DB::table('product as p')
				->select('p.*')
				->where('is_del', 0)
				->whereRAW($where)
				->paginate(1);
			//dd($products);
			$products->appends($data);
			$cateParents='';
			$sonCates= '';

			return view('home/cat/list' ,compact('cateParents', 'sonCates','products' ,'data' ,'myFav'));
		}

		$id = isset($data['id']) ? intval($data['id']) : 0 ;
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
				->paginate(16);
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
				->paginate(16);

			$t3=1;
			return view('home/cat/list' ,compact('cateParents', 'sonCates','products' ,'data','t3','myFav'));
		}
	}


	public function miaosha ( Request $request){

		$id= 13;

		//如果用户登陆了，显示用户收藏的产品
		$userId = Session::get('memberId');
		if(!empty($userId)){
			$myFav = Myfav::getMyFav($userId);
			$myFav = array_column($myFav,'id');
		}


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
			return view('home/cat/miaosha' ,compact('cateParents', 'sonCates','products' ,'data' ,'myFav'));


	}



	function serCate(Request $request){
		$data = $this->inputCheck($request->all());
		$act = isset($data['act']) ? $data['act'] : '';
		$m3_result = new M3Result;
		$user_id = 0;
		if ($act == 'quan_get') {
			//领券需要先登陆
			$user_id = $this->checkLogin();
			if ($user_id == 0) {
				//用户需要登陆
				$m3_result->status = 20;
				$m3_result->message = '登陆后才能领取';
				return $m3_result->toJson();
			}
			//判断库中是否还有此券
			$id = isset($data['id']) ? intval($data['id']) : 0;
			$quan = Quan::where('id', $id)->first();
			//券数量为0  , 或  时间已经过期
			if($quan->num <= 0 || $quan->end_time <= time()) {
				$m3_result->status = 10;
				$m3_result->message = '券已经过期';
				return $m3_result->toJson();
			}
			//如果只有1张了则要更新nostock标志位为1 表示优惠券已经被抢光了
			$nostock = 0;
			if($quan->num == 1){
				$nostock = 1;
				$m3_result->data['nostock'] = 1;
			}
			//事务里处理
			DB::beginTransaction();
			$res1 = Quan::where('id', $id)->update([
				'num' => ($quan->num - 1),
				'receive_num' => ($quan->receive_num + 1),
				'nostock'=> $nostock,
				]);
			//随机从优惠券详情列表中抽取一张给当前用户
			$quanDetails = Quan_issue::where('quan_id', $id)
									->where('is_used', 0)
									->where('is_issue',1 )
									->where('is_recevie',0 )
									->first();
			if(!$quanDetails){
				//没有可用的了，
				DB::rollBack();
				$m3_result->status = 10;
				$m3_result->message = '来晚了，券已经被抢光了！';
				return $m3_result->toJson();
			}
			//会员和优惠券关联表
			$res2 = Member_quan:: insertGetId([
				'member_id' => $user_id,
				'quan_id' => $id,
				'quan_sn' => $quanDetails->sn,
			]);
			//quan_issue 对应的券设置为已被领取
			$res3 = Quan_issue::where('id',$quanDetails->id)->update(['is_recevie'=>1]);
			if($res2 && $res3){
				DB::commit();
				$m3_result->status = 0;
				$m3_result->message = '已领取';
				return $m3_result->toJson();
			}else{
				DB::rollBack();
				$m3_result->status = 10;
				$m3_result->message = "异常,重新领取";
				return $m3_result->toJson();
			}










		}
	}


}
