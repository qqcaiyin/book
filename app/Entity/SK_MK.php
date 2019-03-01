<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SK_MK extends Model
{
	protected $table = 'sk_mk';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}