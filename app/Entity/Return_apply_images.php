<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Return_apply_images extends Model
{
	protected $table = 'return_apply_images';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
