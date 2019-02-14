<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Myfav extends Model
{
	protected $table = 'member_fav';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段

	//获取会员的收藏
	public static function getMyFav($uid = 0){

		$data =Myfav::where('member_id',$uid)
			->join('product','product.id','=','member_fav.product_id')
			->select('product.id','product.name','product.preview','product.price'    )
			->get()->toarray();
		return $data;
	}

}
