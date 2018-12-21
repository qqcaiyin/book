<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Pdt_images extends Model
{
	protected $table = 'pdt_images';
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $guarded = [];
}
