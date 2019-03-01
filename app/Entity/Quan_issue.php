<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Quan_issue extends Model
{
	protected $table = 'quan_issue';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
