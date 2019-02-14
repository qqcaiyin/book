<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
	protected $table = 'nav';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段

	/**
	 * 获取主导航
	 * @return array 主导航列表
	 */
	public  static function getNav(){
		$data =Nav::where('is_show',1)->orderby('sort','desc')->get();
		return $data;
	}
}
