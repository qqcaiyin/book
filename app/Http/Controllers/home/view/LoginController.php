<?php

namespace App\Http\Controllers\Home\View;

use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Keywords;
use App\Entity\Member;
use App\Entity\Nav;
use App\Entity\Pdt_content;
use App\Entity\Pdt_images;
use App\Entity\Product;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{


	/**
	 * 登陆界面
	 * @return
	 */
	public function toLogin(){

		//判断会员是否已经登陆
		if($memberName=Session::get('member')){
			return redirect('home/index');
		}else{
			//获取上一次访问的地址
			$http_refer = $_SERVER['HTTP_REFERER'];
			$http_refer = urlencode($http_refer);
			//return redirect(urlencode($http_refer) );
			return view('home/login',compact('http_refer'));
		}
	}

	/**
	 * 注册界面
	 * @return
	 */
	public function toRegister(){


		return view('home/register');
	}


//////////////////////////////////////////////////////////////////////////////

	/**
	 * 登陆验证
	 * @return[type][description]
	 */
	function  homelogin(Request $request){

		$m3_result = new M3Result;

		$data = $request->except('_token');
		//去掉输入的空格等
		$data = $this->inputCheck($data);

		//判断登陆的路径
		if(isset($data['code']))
		{
			//获取验证码，并验证
			$mCode = Session::get('code');
			if(strtoupper($data['code'] )!= $mCode){
				$m3_result->status = 10;
				$m3_result->message = '验证码错误';
				return $m3_result->toJson();
			}
		}


		//根据手机号/email来组合验证规则
		$rule='required';
		$count = substr_count('@',$data['username']);
		if($count==1){
			$rule .='|email';
		}else if($count == 0){
			$rule .='|digits:11';
		}else{
			$m3_result->status = 11;
			$m3_result->message = '账号或密码不对';
			return $m3_result->toJson();
		}

		if($data){
			$rules=[
				'username'=>$rule,
				'password'=>'required|between:6,20',
			];
			$message=[
				'username.required'=>'账号不能为空',
				'password.required'=>'密码不能空',
				'password.between'=>'密码必须6-20位之间',
			];

			$validator = Validator::make($data,$rules,$message);
			if($validator->passes()){
				$res = Member::userLogin($data);
				if($res){
					//登陆成功，保存信息到session
					Session::put('memberId',$res->id);
					Session::put('member',$res->nickname);
					$m3_result->status = 0;
					$m3_result->message = 'ok';
				}else{
					$m3_result->status = 12;
					$m3_result->message = '账号或密码不对';
				}
			}else{
				//验证不通过
				$m3_result->status = 13;
				$m3_result->message = '账号或密码不对';
			}

		}
		return $m3_result->toJson();

		//过滤用户输入
		$data = $this->inputCheck($data);
		$username = $data['username'];
		$password = MD5($data['password']);
		//输入有空
		if(empty($username) ||empty($password)){
			$m3_result->status = 10;
			$m3_result->message = "不能为空";
			return $m3_result->toJson();
		}
		$res = Member::where('nickname',$username)->where('password',$password)->first();
		if($res){
			$m3_result->status = 0;
			$m3_result->message = "登陆成功";
			Session::put('memberid',$res->id);
		}else{
			$m3_result->status = 10;
			$m3_result->message = "用户名或密码不对";
		}
		return $m3_result->toJson();


	}
	/**
	 * 用户输入过滤
	 * @return[type][description]
	 */
	function inputCheck($data){
		foreach($data as $key =>&$d){
			$d = trim($d);
			$d = stripslashes($d);
			$d = htmlspecialchars($d);
		}
		return $data;
	}
	/**
	 * 退出登陆
	 * @return
	 */
	public function toOut(){
		Session::put('member','');
		Session::put('memberId','');
		return redirect($_SERVER["HTTP_REFERER"]);
	}

}
