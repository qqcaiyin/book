<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member_log extends Model
{
	protected $table = 'member_log';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段



	//更新会员信息
	public  static  function insertUserLog($data = array()){
		$res = 0;
		if( $data){
			$res = Member_log::insertGetId($data);
		}
		return $res;
	}


}
