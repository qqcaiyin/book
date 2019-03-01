<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Return_log extends Model
{
	protected $table = 'return_log';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
