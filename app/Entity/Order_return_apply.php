<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order_return_apply extends Model
{
	protected $table = 'order_return_apply';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
