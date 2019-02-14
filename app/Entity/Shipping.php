<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Shipping extends Model
{
	protected $table = 'shipping';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段



	/**
	 * 获取指定id 的快递信息
	 * @param    $ship_id
	 * @return
	 */
	public static function getShipping($ship_id = 0){
		$res = 0;
		if($ship_id){
			$res = Shipping::find($ship_id);
			if($res){
				$res = $res->toarray();
			}
		}
		return $res;
	}



}
