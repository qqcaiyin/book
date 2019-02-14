<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member_addr extends Model
{
	protected $table = 'member_address';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段

	//获取用户所有的地址
	public  static function getAddress($id){
		$res = Member_addr::where('member_address.member_id',$id)
				->orderby('is_default','desc')
				->leftjoin('hat_province as p', 'member_address.province', '=','p.provinceID')
				->leftjoin('hat_city as c', 'member_address.city', '=','c.cityID')
				->orderby('member_address.is_default','desc')
				->select('member_address.*' ,'p.province','c.city')
				->get()->toarray();

		return $res;
	}

	//获取指定id的地址信息
	public static function getOneAddress($uid = 0, $addr_id = 0){
		$res =0;
		if($uid != 0 && $addr_id != 0 ){
			$res = Member_addr::where('member_id',$uid)
				->where('id',$addr_id)
				->first();
			if(!$res){
				$res = 0 ;
			}else{
				$res = $res->toarray();
			}
		}
		return $res;
	}


}
