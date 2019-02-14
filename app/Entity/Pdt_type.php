<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Pdt_type extends Model
{
	protected $table = 'pdt_type';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
