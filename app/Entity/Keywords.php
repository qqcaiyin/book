<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Keywords extends Model
{
	protected $table = 'keywords';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
	 static function getKeywords( $num = 5){
		$result = Keywords::orderby('count','desc')->limit($num)->get();
		return $result;
	}


}
