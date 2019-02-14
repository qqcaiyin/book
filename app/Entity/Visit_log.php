<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Visit_log extends Model
{
	protected $table = 'visit_log';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段
}
