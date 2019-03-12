<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Comment extends Model
{
	protected $table = 'comment';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段

	/**
	 * 获取一个商品的信息
	 * @param  id 商品id
	 * @return array
	 */
	public static function getOneProduct($goodId =0){

		return Product::find($goodId)->toarray();

	}




}
