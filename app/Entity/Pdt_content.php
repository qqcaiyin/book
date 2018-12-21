<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Pdt_content extends Model
{
	protected $table = 'pdt_content';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
}
