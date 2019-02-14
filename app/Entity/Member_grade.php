<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member_grade extends Model
{
	protected $table = 'member_grade';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
