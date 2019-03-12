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

	//获取某一位会员是否收藏指定商品
	public static function userFavStatus($userId = 0,$goodId = 0){

		$res =Myfav::where('member_id',$userId)
			->where('product_id',$goodId )->first();
		if($res){
			return 1;
		}
		return 0;
	}

}
