<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Province extends Model
{
	protected $table = 'hat_province';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
	//保护字段


}
