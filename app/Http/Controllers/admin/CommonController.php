<?php

namespace App\Http\Controllers\Admin;

use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class CommonController extends Controller
{

	public function __construct(){
		$username = Session::get('admin');
		if(!isset($username)){

		}
	}
}
