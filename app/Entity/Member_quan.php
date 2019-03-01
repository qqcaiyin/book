<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member_quan extends Model
{
	protected $table = 'member_quan';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段


	/**
	 * 获取会员的优惠券
	 * @param   $uid   用户id
	 * @param   $where   查询的条件
	 * @return[type][description]ser
	 */
	public static function getUserQuan($uid = 0,$where =''){
		$res = 0;
		if($uid){
			$res = Member_quan::where('member_quan.member_id', $uid)
				->leftjoin('quan','quan.id','=','member_quan.quan_id')
				->leftjoin('quan_issue as qi', 'qi.sn','=','member_quan.quan_sn')
				->whereRAW($where)
				->select('member_quan.*','quan.*')
				->get()->toarray();
			if(!$res){
				$res = 0;
			}
		}
		return $res;
	}

	/**
	 * 判断优惠券是否可用
	 * @param   $uid   用户id
	 * @param   $quan_sn   优惠券卡号
	 * @return
	 */
	public static function getQuanState($uid = 0,$quan_sn=''){
		$res = 0;
		if($uid && !empty($quan_sn)){
			$res = Member_quan::where('member_quan.member_id', $uid)
				->leftjoin('quan_issue as qi', 'qi.sn','=','member_quan.quan_sn')
				->where('qi.is_used',0)
				->where('qi.is_overdue',0)
				->first();
			if(!$res){
				$res = 0;
			}else{
				$res = $res->toarray();
			}
		}
		return $res;
	}

	/**
	 * 优惠券使用后 更新状态
	 * @param   $uid   用户id
	 * @param   $quan_sn   优惠券卡号
	 * @return
	 */

	public static function updateQuanState($uid = 0, $qid = 0, $quan_sn = ''){
		$res = 0;
		if($uid && !empty($quan_sn)){

			$res = Quan_issue::where('sn',$quan_sn)->update([
				'is_used' => 1,
				'used_time' => time()
			]);
			if(!$res) {
				$res = 0;
				return $res;
			}
			$res = Quan::where('id',$qid)->increment('used_num',1);
			if(!$res){
				$res = 0;
				return $res;
			}
		}
		return $res;

	}


}
