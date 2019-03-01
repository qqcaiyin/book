<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Distrib extends Model
{
	protected $table = 'distrib';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段


	public static function insertData($data){
		$res =Distrib:: insertGetId($data);

		return $res ;

	}

}
