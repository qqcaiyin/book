<?php

namespace App\Http\Controllers\Service;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tool\SMS\SendTemplateSMS;
use App\Entity\TempPhone;
use App\Entity\Member;
use App\Entity\TempEmail;
use App\Models\M3Result;
use App\Models\M3Email;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Tool\Validatecode\Code;
use App\Tool\UUID;

class MemberController extends Controller
{

	public function register(Request $res){
		$email = $res->input('email','');
		$phone = $res->input('phone','');
		$password = $res->input('password','');
		$confirm = $res->input('confirm','');
		$phone_code = $res->input('phone_code','');
		$validate_code = $res->input('validate_code','');
		$m3_result = new M3Result;

		if($email == '' && $phone == ''){
			$m3_result->status = 1;
			$m3_result ->message = "手机号或者邮箱不能为空";
			return $m3_result->toJson();
		}
		if($password == '' && strlen($password ) < 6){
			$m3_result->status = 2;
			$m3_result ->message = "密码不少于6位";
			return $m3_result->toJson();
		}
		if($confirm == '' && strlen($confirm ) < 6){
			$m3_result->status = 3;
			$m3_result ->message = "确认密码不少于6位";
			return $m3_result->toJson();
		}
		if($password != $confirm){
			$m3_result->status = 4;
			$m3_result ->message = "两次密码不一致";
			return $m3_result->toJson();
		}

// 手机号注册
		if($phone != '') {
			if($phone_code == '' || strlen($phone_code) != 6) {
				$m3_result->status = 5;
				$m3_result->message = '手机验证码为6位';
				return $m3_result->toJson();
			}
			$tempPhone = TempPhone::where('phone',$phone)->first();
			if(empty($tempPhone)){
				$m3_result->status = 6;
				$m3_result ->message = "重新发送验证码";
				return $m3_result->toJson();
			}

			if($tempPhone->code == $phone_code) {
				if (time() > $tempPhone->deadline) {
					$m3_result->status = 7;
					$m3_result->message = "验证码过期";
					return $m3_result->toJson();
				}
				$member = new Member;
				$member->phone = $phone;
				$member->password = md5( + $password);
				$member->save();

				$m3_result->status = 0;
				$m3_result->message = "注册成功";
				return $m3_result->toJson();
			}else{
				$m3_result->status = 8;
				$m3_result->message = "手机验证码不对";
				return $m3_result->toJson();
			}


		}else{
			if($validate_code == '' || strlen($validate_code) != 4) {
				$m3_result->status = 9;
				$m3_result->message = '验证码为4位';
				return $m3_result->toJson();
			}
			//有注册时的验证码
			$_mmcode = Session::get('code');

			if(strtoupper($validate_code) != $_mmcode ) {
				$m3_result->status = 10;
				$m3_result->message = '验证码不正确';
				return $m3_result->toJson();
			}

			$tempmember = Member::where('email',$email)->first();

			if(!empty($tempmember)){
				$m3_result->status = 11;
				$m3_result ->message = "用户已注册";
				return $m3_result->toJson();
			}

			$member = new Member;
			$member->email = $email;
			$member->password = md5($password);
			$member->save();

			$uuid = UUID::create();

			//邮箱验证
			$m3_email = new M3Email;
			$m3_email->to = $email;
			$m3_email->cc = '530667695@qq.com';
			$m3_email->subject = '个人书店内容';
			$m3_email->content = ' 请于24小时内完成该链接的验证。http://book.com/service/validate_email'
			                     . '?member_id='.$member->id
				                  . '&code=' . $uuid;

			Mail::send('email_register',
				 ['m3_email' => $m3_email],
				function($m) use($m3_email){
					$m->to($m3_email->to,'尊敬的用户')
						->cc($m3_email->cc)
						->subject($m3_email->subject);
			});
			$tempEmail = new TempEmail;
			$tempEmail->member_id = $member->id;
			$tempEmail->code = $uuid;
			$tempEmail->deadline = time()+24*60*60;
			$tempEmail->save();
		}
		$m3_result->status = 0;
		$m3_result->message = "注册成功";
		return $m3_result->toJson();
	}

	public function login(Request $res){


		$input = Input::all();
		$username = $res->get('username','');
		$password = $res->get('password','');
		$validate_code = $res->get('validate_code','');

		$m3_result = new M3Result;

		//校验

		//判断验证码是否正确
		$_code = Session::get('code');
		if(strtoupper($validate_code) != $_code){
			$m3_result->status = 1;
			$m3_result->message = "验证码错误";
			return $m3_result->toJson();
		}
		if(strpos($username,'@') == true)
		{
			$member = Member::where('email', $username)->first();
		}else{
			$member = Member::where('phone', $username)->first();
		}

		if($member == null ){
			$m3_result->status = -3;
			$m3_result->message = "该用户不存在";
			return $m3_result->toJson();
		}
		if(md5($password) != $member->password){
			$m3_result->status = -4;
			$m3_result->message = "密码不正确";
			return $m3_result->toJson();
		}
		$m3_result->status = 0;
		$m3_result->message = "登录成功";

		Session::put('username',$username);
		Session::put('password',$password);

		return $m3_result->toJson();

	}
}
