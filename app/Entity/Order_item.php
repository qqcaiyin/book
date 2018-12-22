<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
	protected $table = 'order_item';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
