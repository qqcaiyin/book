<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member_wx extends Model
{
	protected $table = 'member_wx';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段

	//test

	public static function getByOpenId($openid = ''){

		return self::where('openid',$openid)->first();


	}

	///////////////////////








	//验证用户信息
	public  static function userLogin($data){
		$result = Member::where('phone',$data['username'])
			->where('password',md5($data['password']))
			->orwhere('email',$data['username'])
			->first();
		return $result;
	}




	//获取会员的详细信息
	public static  function getUser($uid = 0){
		$res = 0;
		if($uid != 0){
			$res = Member::where('id',$uid)->first();
			if($res){
				$res = $res->toarray();
			}
			//待付款
			$topay = Order::where('member_id',$uid)->where('status',0)->count();
			//待发货
			$tosend = Order::where('member_id',$uid)->where('status',4)->count();
			//待收货
			$torecive = Order::where('member_id',$uid)->where('status',5)->count();
			//待评价
			$toeval = Order::where('member_id',$uid)->where('status',6)->count();

			$res['topay'] = $topay;
			$res['tosend'] = $tosend;
			$res['torecive'] = $torecive;
			$res['toeval'] = $toeval;

		}
		return $res;
	}

	//更新会员信息
	public  static  function updateUserInfo($uid = 0, $data = array()){
		$res = 0;
		if($uid && $data){
			$res = Member::where('id',$uid)->update($data);
			//dd($res);
		}
		return $res;
	}

	public static function getUserInfo($uid = 0){
		$res = 0;
		if($uid!=0){
			$res = Member::find($uid);
			if($res){
				$res =$res->toarray();
			}
		}
		return $res;
	}


}
