<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Distrib;
use App\Entity\Product;
use App\Entity\Quan;
use App\Entity\Quan_issue;
use App\Entity\SK_MK;
use App\Jobs\OrderCancel;
use App\Jobs\SendReminderEmail;
use App\Models\M3Result;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class MarketController extends Controller
{


	/**
	 * 添加秒杀商品
	 * @return
	 */
	public function toSkipeAdd(){
		return view('admin/market/skipe_add');

	}
	/**
	 * 编辑秒杀商品
	 * @return
	 */
	public function toSkipeEdit(Request $request){
		$data = $request->all();
		$id= isset($data['id'])? intval($data['id']) :0;
		$skipedetails = SK_MK::where('id',$id)->first();
		if($skipedetails){
			$skipedetails->num = count(explode(',' ,$skipedetails->good_ids  ));
		}
		return view('admin/market/skipe_edit',compact('skipedetails'));

	}
	/**
	 * 秒杀商品列表
	 * @return
	 */
	public function toSkipeList(){
		$skipeList = SK_MK::orderBy('id','desc')->get();
		return view('admin/market/skipe_list' ,compact('skipeList'));

	}

	/**
	 * 添加分销
	 * @return
	 */
	public function toDistribAdd(){

		$job = (new SendReminderEmail(3))->delay(Carbon::now()->addMinutes(1));
		$this->dispatch($job);

//echo  Carbon::now()->addMinutes(2);
		return view('admin/market/distrib_add');

	}

	/**
	 * 优惠券列表
	 * @return
	 */
	public function toQuanList(){

		$quanList = Quan::orderBy('id','desc')->get();
		return view('admin/market/quan_list' ,compact('quanList'));

	}
	/**
	 * 添加优惠券
	 * @return
	 */
	public function toQuanAdd(){


		return view('admin/market/quan_add');

	}
	/**
	 * 编辑优惠券
	 * @return
	 */
	public function toQuanEdit( Request $request){
		$data =$request->all();
		$quan_id = isset($data['id']) ? intval($data['id']) :0;
		$quanDetail = Quan::where('id',$quan_id)->first();
		return view('admin/market/quan_edit',compact('quanDetail'));

	}
	/**
	 * 优惠券-详细列表
	 * @return
	 */
	public function toQuanIssue( Request $request){
		$data = $request->all();
		$quan_id = isset($data['id']) ? intval($data['id']) :0;
		$quanList = Quan_issue::where('quan_issue.quan_id',$quan_id)
			->leftjoin('member_quan','member_quan.quan_sn','=','quan_issue.sn')
			->leftjoin('member','member.id','=','member_quan.member_id')
			->leftjoin('quan','quan.id','=','quan_issue.quan_id')
			->select('quan_issue.*','member.nickname','quan.start_time','quan.end_time','quan.name')
			->orderBy('quan_issue.id','desc')->get();
		$quanName = $quanList[0]->name;
		return view('admin/market/quan_issue' ,compact('quanList','quanName'));

	}

	/**
	 * 所有商品表 -弹出层
	 * @return
	 */
	public function pdtList(Request $request){

			$data= $request->all();
			$where =1;
//判断是否点击搜索了
			if(isset($data['is_search'])){
				if (!empty($data['keywords'])) {
					$where .= ' and p.name like "%' . trim($data['keywords']) . '%" ';
				}
				if ($data['category_id'] != 0) {
					$where .= ' and c.path like "%,' .trim( $data['category_id']) . ',%"';
				}
				//查找满足条件的数据
				$products = DB::table('product as p')
					->leftjoin('category as c', 'p.category_id', '=', 'c.id')
					->select('p.*')
					->whereRAW($where)
					->where('is_del', 0)
					->orderby('id', 'desc')
					->paginate(10);
				//搜索分页时追加的搜索条件
				$appendData = array(
					'is_search' => 1,
					'category_id' => $data['category_id'],
					'keywords' => trim($data['keywords'])
				);
				$products->appends($appendData);
				//用于回显
				$products->search = $appendData;
			}else{
//非搜索情况，获取产品的数据
				$products = Product::where('is_del',0)->orderby('id','desc')->paginate(5);
			}

			//获取每个产品对应的父类列表
			$_cate = array();
			foreach ($products as $product) {
				if ($product->category_id != 0) {
					$category = Category::find($product->category_id);
					$_cate = explode(',', $category->path);
					array_shift($_cate);
					array_pop($_cate);
					$product->category = Category::whereIn('id', $_cate)->get();
				}
			}
			//获取下拉分类栏
			$cate = $this->_getTree();
			return  view('admin/market/product' ,compact('products','cate'));
	}
	/**
	 * 获取分类树
	 * @return obj
	 */
	private function _getTree(){
		$categories = Category::select('id','name','parent_id','path')->orderby('path','asc')->get();
		foreach ($categories as $category){
			$arr = explode(',',$category->path);
			$tot = count($arr)-3;
			$category->name =str_repeat('|----',$tot).$category->name;
		}
		return $categories;
	}


	public function serMarket(Request $request){
		$data = $request->all();
//dd($data);
		$m3_result = new M3Result;
		$act = isset($data['act']) ? $data['act'] :'';
		if($act =='add_skipe' ||$act == 'edit_skipe'){
			$id = isset($data['id']) ?  intval($data['id']) :0;
			$name = isset($data['name']) ? $data['name'] :'';
			$enbale = isset($data['enable']) ? $data['enable'] :0;
			$starttime = isset($data['starttime']) ? strtotime($data['starttime'])   :0;
			$endtime = isset($data['endtime']) ?  strtotime($data['endtime']) :0;
			$ty = isset($data['ty']) ?  intval($data['ty']) :0;
			$val = isset($data['val']) ?  $data['val'] :0;
			$good_ids = isset($data['good_ids']) ? $data['good_ids'] :'';
			$des = isset($data['des']) ? $data['des'] :'';

			if($name == '' ||$starttime == 0||$endtime == 0|| $val == ''|| $good_ids == '' ||$starttime>=$endtime ||$starttime<time()){
				$m3_result->status = 10;
				$m3_result->message = "信息未填完整";
				return$m3_result->toJson();
			}

			if($act == 'add_skipe'){
				$res = SK_MK:: insertGetId([
					'name' => $name,
					'enable' => $enbale,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'ty' => $ty,
					'val' => $val,
					'good_ids' => $good_ids,
					'des' => $des,
				]);
			}else{
				$res = SK_MK:: where('id',$id)->update([
					'name' => $name,
					'enable' => $enbale,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'ty' => $ty,
					'val' => $val,
					'good_ids' => $good_ids,
					'des' => $des,
				]);
			}

			if($res){
				$m3_result->status = 0;
				$m3_result->message = "ok";
				return$m3_result->toJson();
			}else{
				$m3_result->status = 10;
				$m3_result->message = "重新提交";
				return$m3_result->toJson();
			}
		}else if($act =='del_skipe'){
			$id = isset($data['id']) ?  intval($data['id']) :0;
			if($id == 0){
				$m3_result->status = 10;
				$m3_result->message = "编号异常";
				return$m3_result->toJson();
			}

			$res = SK_MK::where('id',$id)->delete();
			if($res){
				$m3_result->status = 0;
				$m3_result->message = "删除成功";
				return$m3_result->toJson();
			}else{
				$m3_result->status = 10;
				$m3_result->message = "删除失败";
				return$m3_result->toJson();
			}
		}else if($act =='add_distrib'){
			$arr =array();
			$arr['name'] = isset($data['name']) ?  $data['name'] :0;
			$arr['level_type']= isset($data['level_type']) ? intval($data['level_type'] )  :0;
			$arr['level1']= isset($data['level1']) ? intval($data['level1'] )  :0;
			$arr['level2']= isset($data['level2']) ? intval($data['level2'] )  :0;
			$arr['level3']= isset($data['level3']) ? intval($data['level3'] )  :0;
			$arr['expire']= isset($data['expire']) ? intval($data['expire'] )  :0;
			$res = Distrib::updateData( $arr);
			if($res){
				$m3_result->status = 0;
				$m3_result->message = "添加成功";
				return$m3_result->toJson();
			}else{
				$m3_result->status = 10;
				$m3_result->message = "添加失败";
				return$m3_result->toJson();
			}

		}else if($act == 'add_quan' || $act == 'quan_edit'){
//添加优惠券,编辑优惠券
			//dd($data);
			$arr =array();

			$arr['name'] = isset($data['name']) ?  $data['name'] :'';
			$arr['parvalue']= isset($data['parvalue']) ? intval($data['parvalue'] )  :0; //面值
			$arr['needpoint']= isset($data['needpoint']) ? intval($data['needpoint'] )  :0; //面值
			$arr['amount_reached']= isset($data['amount_reached']) ? intval($data['amount_reached'] )  :0;
			$arr['get_type']= isset($data['get_type']) ? intval($data['get_type'] )  :0;
			$arr['is_enable']= isset($data['is_enable']) ? intval($data['is_enable'] )  :0;
			$arr['user_limit_num']= isset($data['user_limit_num']) ? intval($data['user_limit_num'] )  :0;
			$arr['user_day_num']= isset($data['user_day_num']) ? intval($data['user_day_num'] )  :0;
			$arr['limitation']= isset($data['limitation']) ? intval($data['limitation'] )  :0;
			$arr['start_time'] = isset($data['start_time']) ? strtotime(trim($data['start_time'] ) ) :0;
			$arr['end_time'] = isset($data['end_time']) ?  strtotime(trim($data['end_time'] ) ):0;

			if($arr['start_time']  > $arr['end_time']  ||  $arr['end_time']< time() ){
				$m3_result->status = 0;
				$m3_result->message = "日期设置不对";
				return$m3_result->toJson();
			}

			if($act =='quan_edit'){
				$id = isset($data['id']) ? intval($data['id'] ) : 0;
				$res = Quan::where('id',$id)->update($arr);
				if(!$res){
					$m3_result->status = 10;
					$m3_result->message = "修改失败，请重新提交";
					return$m3_result->toJson();
				}
				$m3_result->status = 0;
				$m3_result->message = "修改成功";
				return$m3_result->toJson();
			}else{
				$res = Quan::insertGetId($arr);
				if(!$res){
					$m3_result->status = 10;
					$m3_result->message = "添加失败，请重新提交";
					return$m3_result->toJson();
				}
				$m3_result->status = 0;
				$m3_result->message = "添加成功";
				return$m3_result->toJson();
			}

		}else if($act =='issue_quan'){
//设置发行券数量
		//	dd($data);
			$id = isset($data['id']) ? intval($data['id'] )  :0;
			$num = isset($data['num']) ? intval($data['num'] )  :0;

			DB::beginTransaction();
			$res1 = Quan::where('id',$id)->increment('num',$num);
			$res2 = $this->issueQuan($id , $num);
			if($res1 ){
				DB::commit();
				$m3_result->status = 0;
				$m3_result->message = "发布成功";
				return $m3_result->toJson();
			}else{
				DB::rollBack();
				$m3_result->status = 10;
				$m3_result->message = "异常，请重新发布";
				return $m3_result->toJson();
			}
		}else if( $act =='quan_detail_del'){
//删除详情列 里的  具体的优惠券
			$id = isset($data['id']) ? intval($data['id'] )  :0;
			$quan_id = isset($data['quan_id']) ? intval($data['quan_id'] )  :0;

			DB::beginTransaction();
 			//删除优惠券
			$res1 = Quan_issue::where('id',$id)->where('quan_id',$quan_id)->delete();
			//更新优惠券数量
			$res2 = Quan::where('id',$quan_id)->decrement('num',1);

			if($res1 && $res2){
				DB::commit();
				$m3_result->status = 0;
				$m3_result->message = "ok";
				return $m3_result->toJson();
			}else{
				DB::rollBack();
				$m3_result->status = 10;
				$m3_result->message = "删除失败，请重新尝试";
				return $m3_result->toJson();
			}
		}else if($act == 'quan_detail_issue'){
			$id = isset($data['id']) ? intval($data['id'] )  :0;
			$t = 0;
			$quanDetail = Quan_issue::where('id',$id)->first();
			if($quanDetail == null){
				$m3_result->status = 10;
				$m3_result->message = "重试";
				return $m3_result->toJson();
			}
			if($quanDetail->is_issue ==0){
				$t = 1;
				$m3_result->data['issue'] = 1;
			}else if($quanDetail->is_issue ==1){
				$m3_result->data['issue'] = 0;
			}
			$res = Quan_issue::where('id',$id)->update(['is_issue'=>$t]);
			if($res){
				$m3_result->status = 0;
				$m3_result->message = "发布";
				return $m3_result->toJson();
			}else{
				$m3_result->status = 10;
				$m3_result->message = "禁用";
				return $m3_result->toJson();
			}

		}


	}


	public function   issueQuan( $id =0, $num = 0 ){
		$res = 0;
		if($id !=0 && $num !=0){
			for($i= 0; $i< $num ; $i++){
				$sn = $this->quanCreateSn( $id );
				$res =  Quan_issue::insertGetId(['quan_id' =>$id, 'sn' => $sn]);
				if($res){

				}else{
					$res = 0;
					break;
				}
			}
		}
		return $res;
	}


	/**
	 * 生成优惠券编号
	 * @return  string
	 */
	protected function quanCreateSn($id = 0){
		$date = date('ymd');
		$rand = rand(1000,9999);
		$sn = $date . $rand;
		//判断库里是否有相同的订单编号
		$res = DB::table('quan_issue')->where('sn',$sn)->where('quan_id',$id)->get();
		if($res){
			$this->quanCreateSn();
		}
		return $sn;

	}





}
