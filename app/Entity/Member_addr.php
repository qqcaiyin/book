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

	public function provinces(){
		return $this->hasOne('App\Entity\Province','provinceID','province');
	}



	//获取用户所有的地址
	public  static function getAddress($userId = 0,$is_checked = 0 ){
		$where = '  member_id=70  ';
		if($is_checked){
			$where  .= ' and (is_checked=1  ) ';
		}
		$res = Member_addr::whereRaw($where)
				->orderby('is_default','desc')
				->leftjoin('hat_province as p', 'member_address.province', '=','p.provinceID')
				->leftjoin('hat_city as c', 'member_address.city', '=','c.cityID')
				->orderby('member_address.is_default','desc')
				->select('member_address.*' ,'p.province','c.city')
				->get()->toarray();

		return $res;
	}




	//获取指定id的地址信息
	public static function getAddrById( $addr_id = 0){
		return  Member_addr::where('member_address.id',$addr_id)
			->leftjoin('hat_province as p', 'member_address.province', '=','p.provinceID')
			->leftjoin('hat_city as c', 'member_address.city', '=','c.cityID')
			->first();
	}


}
