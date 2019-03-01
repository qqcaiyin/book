<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Quan extends Model
{
	protected $table = 'quan';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
