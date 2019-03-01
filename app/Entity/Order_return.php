<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order_return extends Model
{
	protected $table = 'order_return';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
