<?php

namespace App\Http\Controllers\View;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
	public function tologin( Request $request){

		$return_url = $request->input('return_url','');
		return view('login')->with('return_url', urldecode($return_url));
	}

	public function register(){
		return view('register');
	}
}
