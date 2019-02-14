<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Pdt_attr extends Model
{
	protected $table = 'pdt_attr';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
