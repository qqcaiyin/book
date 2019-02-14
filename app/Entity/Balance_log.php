<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Balance_log extends Model
{
	protected $table = 'balance_log';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
