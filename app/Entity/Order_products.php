<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order_products extends Model
{
	protected $table = 'order_products';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
