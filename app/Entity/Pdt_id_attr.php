<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Pdt_id_attr extends Model
{
	protected $table = 'pdt_id_attr';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
