<?php

namespace App\Http\Controllers\Admin;


use App\Entity\Balance_log;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Member;
use App\Entity\Member_grade;
use App\Entity\Member_log;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use function PHPSTORM_META\type;
use DB;
	class MemberController extends Controller
{

	public function toMember(Request $request){

		$data = $request->all();
		$where=1;
		//判断是否搜索
		if(isset($data['is_search'])){
			if(($enbale = $data['enable'])!= 2){
				$where = ' enable='.$enbale;
			}
			if($nickname = $data['keywords']){
				$where .= ' and nickname like "%'.$nickname .'%" ';
			}
			//dd($where);
			//根据搜索条件查找数据表  原生SQL语句
			$members = Member::whereRaw($where)->paginate(15);
			//使用appends把参数配置上，
			//$request->input取得是url参数的值，把参数拼进去。再点击下一页的时候就链接跳转进入控制器处理，就可以获取到查询条件了。
			$appendData = $members->appends(array(
				'is_search' => 1,
				'enable' => $data['enable'] ,
				'keywords' => $data['keywords'],
			));
		}else{
			$members = Member::orderby('id','desc')->paginate(15);
		}
		return  view('admin/member/list',compact('members'));
	}

	/**
	 *会员添加界面
	 *
	 */
	public function toMemberAdd(){

		return  view('admin/member/add');
	}

	/*
	 * 会员资金管理界面
	 *
	 */
	public function toMoney( $id){

		$member = Member::find($id);
		return view('admin/member/money',compact('member'));
	}
	/*
	 * 会员等级界面
	 *
	 */
		public function toMemberGrade(){

			$grades = Member_grade::orderby('id','asc')->get();
			return  view('admin/member/grade',compact('grades'));
		}


	/*
	 * 显示会员名片
	 * @param interger $id 会员编号
	 */
	public function memberShow($id){

		$member = Member::find($id);
		//默认的收件地址
		$memberAddr = DB::table('member_address as ma')
						->join('hat_province as hp' ,'hp.provinceID','=','ma.province')
						->join('hat_city as hc' ,'hc.cityID','=','ma.city')
						->where('ma.member_id',$id)
						->where('ma.is_default',1)->first();
		//dd($memberAddr);
		return view('admin/member/show',compact('member','memberAddr'));
	}
	/*
	 * 用户评价列表
	 *
	 */
	public function toComments(){


		$comments = Comment::where('comment.is_del',0)
			->orderby('comment.id','desc')
			->leftjoin('product' ,'product.id','=','comment.pdt_id')//产品名称
			->leftjoin('member','member.id','=','comment.member_id')
			->select('comment.*','product.name','member.nickname')
			->paginate(15);

		return view('admin/member/comment_list', compact('comments'));



	}



//////////////////////////数据处理//////////////////////////////////////////////////
	/*
	 * 用户的禁用和解禁
	 *
	 */
	public function memberEnable( Request $request){
		$m3_result = new M3Result;

		$id = $request->input('id','');
		$_enable = $request->input('_enable','');
		$res = Member::where('id',$id)->update(['enable'=>$_enable]);
		if($res)
		{
			if($_enable == 1)
			{
				$m3_result->status = 0;
				$m3_result->message ="启用成功";
			}else{
				$m3_result->status = 0;
				$m3_result->message ="禁用成功";
			}

		}else{
			if($_enable == 1)
			{
				$m3_result->status = 1;
				$m3_result->message ="启用失败";
			}else{
				$m3_result->status = 1;
				$m3_result->message ="禁用失败";
			}
		}
		return $m3_result->toJson();

	}

	public function memberDel(Request $request){

		$m3_result = new M3Result;

		$member_id = $request->input('member_id','');
		$res = Member::find($member_id)->delete();

		if($res){
			$m3_result->status = 0;
			$m3_result->message = "删除成功";
		}else{
			$m3_result->status = 1;
			$m3_result->message = "删除失败";
		}


		return $m3_result->toJson();
	}


	/**
	 *@param type: name  	等级名称
	 *             mincore 	等级积分下限
	 *             maxcore  等级积分上限
	 * 			   discount  折扣
	 * 				sort    排名
	 *@param id          	类别编号
	 *@param changeValue 	新值
	 */
	public function gradeChangeValue(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "更新成功";

		$all = $request->all();
		//dd($all);
		//获取参数
		$id = $all['id'];
		$tp = $all['tp'];
		$changeValue =trim($all['changeValue']) ;
		switch($tp){
			case 'name1':
				if( !empty($changeValue) ){
					$res_name = Member_grade::where('id',$id)->update(['name'=>$changeValue]);
				}else{
					$m3_result->status = 10;
					$m3_result->message = "不能为空";
				}
				break;
			case 'discount1':
				if( !empty($changeValue)){
					$res_name = Member_grade::where('id',$id)->update(['discount'=>$changeValue]);
				}else{
					$m3_result->status = 10;
					$m3_result->message = "不能为空";
				}
				break;
			case 'mincore1':
				$res_name = Member_grade::where('id',$id)->update(['min_core'=>$changeValue]);
				break;

			case 'maxcore1':
				$res_name = Member_grade::where('id',$id)->update(['max_core'=>$changeValue]);
				break;
			case 'sort1':
				if(is_numeric($changeValue)){
					$changeValue = $changeValue >0? ($changeValue >99? 99:$changeValue) : 0;
					if($changeValue ==99){
						$m3_result->status = 1;
					}
					if($changeValue == 0){
						$m3_result->status = 2;
					}
					$res_order = Member_grade::where('id',$id)->update(['sort'=>$changeValue]);
				}else{
					$m3_result->status = 11;
					$m3_result->message = "填写数字0-99";
				}
				break;
		}

		return  $m3_result->toJson();
	}

	/**
	 *@param id          	等级
	 *@param changeValue 	新值
	 */
	public function  gradeAdd(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "添加成功";

		$all = $request->except('_token');

		//dd($all);
		$res = Member_grade::insertGetId($all);
		if(!$res){
			$m3_result->status = 1;
			$m3_result->message = "添加失败";
		}
		$m3_result->newid = $res;

		return $m3_result->toJson();
	}
	/**删除等级
	 *@param id          	等级编号
	 *@param
	 */
	public function gradeDel(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "删除成功";

		$id = $request->input('id');
		$res =Member_grade::where('id',$id)->delete();
		if(!$res){
			$m3_result->status = 10;
			$m3_result->message = "删除失败";
		}

		return  $m3_result->toJson();
	}



	public function memberAdd(Request $request){

		$m3_result = new M3Result;

		$all = $request->all();

		$_memberAdd = $request->except('_token','sex','file','confirm_password');
		$_memberAdd['nickname'] =addslashes($_memberAdd['nickname']);
		$_memberAdd['password'] = md5($_memberAdd['password']);
		$_memberAdd['register_time'] = date('Y-m-d H:i:s', time());;

		$res = Member::where('phone',$_memberAdd['phone'])->first();
		if($res) {
			$m3_result->status = 10;
			$m3_result->message = "手机号已被使用";
			return $m3_result->toJson();
		}
		$res = Member::where('email',$_memberAdd['email'])->first();
		if($res) {
			$m3_result->status = 10;
			$m3_result->message = "邮箱已被使用";
			return $m3_result->toJson();
		}
		$res = Member::insert($_memberAdd);
		if($res){
			$m3_result->status = 0;
			$m3_result->message = "添加成功";
		}else{
			$m3_result->status = 0;
			$m3_result->message = "更新失败,用户名，电话、邮箱已使用";
		}
		return $m3_result->toJson();
	}
	/**用户 余额， 积分，冻结的操作
	 *@param id          用户编号
	 *@param
	 */
	public function  adjust_balance(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "更改成功";

		$data = $request->all();
		$id = $data['id'];
		//dd($data);
		$blance = $data['balance'];
		$point = $data['point'];
		$freeze = $data['freeze'];
		$balance_type = $data['balance_type'];
		$point_type = $data['point_type'];
		$freeze_type = $data['freeze_type'];
		$pre_openbalance = $data['pre_openbalance'];
		$pre_money = $data['pre_money'];
		$pre_point = $data['pre_point'];
		$pre_freeze = $data['pre_freeze'];

		if( ($balance_type == 0) &&(intval($blance) > intval($pre_openbalance)))
		{
			//减得金额过大；
			$m3_result->status = 11;
			$m3_result->message = "减的金额大于总余额，重新填写";
			return $m3_result->toJson();
		}
		if(($point_type == 0)&&(intval($point)> intval($pre_point))){
			//减得积分大于用户积分；
			$m3_result->status = 14;
			$m3_result->message = "减少的积分大于用户当前总积分，重新填写";
			return $m3_result->toJson();
		}
		if(($freeze_type == 1)&&(intval($freeze)>intval($pre_freeze))){
			$m3_result->status = 16;
			$m3_result->message = "解冻资金大于总冻结资金，重新填写";
			return $m3_result->toJson();
		}
		if(($freeze_type == 0)&&(intval($freeze) > intval($pre_openbalance))) {
			$m3_result->status = 18;
			$m3_result->message = "冻结资金大于总可用资金，重新填写";
			return $m3_result->toJson();
		}
		//余额调整操作   非空才进行加减操作
		if(intval($data['balance'])){
			//获取原来的余额和可用余额
			//增加
			if($balance_type == 1){
				$res_money = Member::increment('money',$blance);
				$res_openbalance = Member::increment('openbalance',$blance);
				if($res_money &&$res_openbalance){
					;
				}else{
					$m3_result->status = 10;
					$m3_result->message = "余额增加失败";
				}

			}else if($balance_type == 0){
				$res_money = Member::where('id',$id)->decrement('money',$blance);
				$res_openbalance = Member::where('id',$id)->decrement('openbalance',$blance);
				if($res_money &&$res_openbalance){
					;
				}else{
					$m3_result->status = 12;
					$m3_result->message = "余额减少失败";
				}
			}
			//把更改记录写到余额 balance_log表中
			$arr = array();
			$arr['member_id'] = $id;
			$arr['type'] ='余额';
			$arr['sign'] = $balance_type;
			$arr['value'] = $balance_type == 1? $blance:'-'.$blance;
			$arr['disc'] = $data['disc'];
			$arr['time'] = time();
			$res = Balance_log::create($arr);
			if(!$res){
				$m3_result->status = 12;
				$m3_result->message = "余额管理失败";
			}

		}
		//积分调整操作  非空才进行
		if(intval($data['point'])){
			//增加
			if($point_type == 1){
				$res_point = Member::where('id',$id)->increment('point',$point);
				if($res_point){
					;
				}else{
					$m3_result->status = 13;
					$m3_result->message = "积分增加失败";
				}
			}else if($point_type == 0){
				//减少
				$res_point = Member::where('id',$id)->decrement('point',$point);
				if($res_point){
					;
				}else{
					$m3_result->status = 15;
					$m3_result->message = "积分减少失败";
				}
			}

			//把积分更改记录写到 balance_log表中
			$arr = array();
			$arr['member_id'] = $id;
			$arr['type'] ='积分';
			$arr['sign'] = $point_type;
			$arr['value'] = $point_type == 1? $point:'-'.$point;
			$arr['disc'] = $data['disc'];
			$arr['time'] = time();
			$res = Balance_log::create($arr);
			if(!$res){
				$m3_result->status = 12;
				$m3_result->message = "余额管理失败";
			}
		}
		//冻结，解冻操作  非空才进行
		if(intval($data['freeze'])){
			//解冻
			if($freeze_type == 1){
				$res_balance = Member::where('id',$id)->increment('openbalance',$freeze);
				$res_freeze = Member::where('id',$id)->decrement('freeze',$freeze);
				if($res_balance &&$res_freeze){
					;
				}else{
					$m3_result->status = 17;
					$m3_result->message = "解冻失败，请再次尝试";
				}
			}else if($freeze_type == 0){
				//冻结
				$res_balance = Member::where('id',$id)->decrement('openbalance',$freeze);
				$res_freeze = Member::where('id',$id)->increment('freeze',$freeze);
				if($res_point ){
					;
				}else{
					$m3_result->status = 10;
					$m3_result->message = "冻结资金失败，请重试";
				}
			}
		}
		return $m3_result->toJson();
	}


	//
	public function serComments(Request $request){
		$data = $request->all();
		$m3_result = new M3Result;
		$act = isset($data['act']) ? $data['act'] :'';
		if($act == 'is_show'){
			//设置留言是否在前端显示
			$id = isset($data['id']) ?intval($data['id']) : 0;
			if($id == 0){
				$m3_result->status = 10;
				$m3_result->message = "刷新页面重试";
				return $m3_result->toJson();
			}
			$res = Comment::where('id',$id)->first();
			if($res->is_show == 1){
				$res = Comment::where('id',$id)->update(['is_show'=>0]);
				if($res){
					$m3_result->status = 4;
					$m3_result->message = "已设置为不显示";
					return $m3_result->toJson();
				}
			}elseif($res->is_show == 0){
				$res = Comment::where('id',$id)->update(['is_show'=>1]);
				if($res){
					$m3_result->status = 3;
					$m3_result->message = "已设置为显示";
					return $m3_result->toJson();
				}
			}

		}else if($act =='del'){
			//设置留言是否在前端显示
			$id = isset($data['id']) ?intval($data['id']) : 0;
			if($id == 0){
				$m3_result->status = 10;
				$m3_result->message = "刷新页面重试";
				return $m3_result->toJson();
			}

			DB::beginTransaction();
			$res1 = Comment::where('id',$id)->update(['is_del'=>1]);
			//$res2 = Comment::where('id',$id)->update(['is_show'=>0]);
			if($res1 ){
				DB::commit();
				$m3_result->status = 0;
				$m3_result->message = "删除成功";
				return $m3_result->toJson();
			}else{
				DB::rollBack();
				$m3_result->status = 10;
				$m3_result->message = "异常，事务回滚";
				return $m3_result->toJson();
			}

		}




	}


}