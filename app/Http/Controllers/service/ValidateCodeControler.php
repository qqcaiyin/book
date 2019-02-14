<?php

namespace App\Http\Controllers\Service;


use App\Entity\Member;
use App\Entity\TempEmail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tool\Validatecode\Code;
use App\Tool\SMS\SendTemplateSMS;
use App\Entity\TempPhone;
use App\Models\M3Result;
class ValidateCodeControler extends Controller
{

	public function create($value=''){
		$v = new Code;
		return $v->make();
	}

	/**
	 *	用户注册接口
	 * @return[type][description]
	 */
	public function userApi(Request $request){

		$m3_result = new M3Result;

		$data = $request->all();
		$data = $this->inputCheck($data);

/**简单注册的号码是否可用**/
		if($data['act'] == 'check_moble'){
			//检测手机号码是否已存在
			$res = Member::where('phone', $data['moble'])->first();
			if($res){
				$m3_result->status = 10;
				$m3_result->message = "本手机号已注册，可直接登录";
			}else{
				$m3_result->status = 0;
				$m3_result->message = "可注册使用";
			}
			return $m3_result->toJson();
		}else if($data['act'] == 'send_sms'){
/**发送短信验证码**/
			return $this->sendSMS($data);

		}else if($data['act'] == 'reg'){
/**注册**/
			$res = Member::where('phone',$data['tel'])->first();
			if($res){
				$m3_result->status = 0;
				$m3_result ->message = "已注册成功";
				return $m3_result->toJson();
			}
			//读取库中是否包含此号码的短信验证码
			$tempPhone = TempPhone::where('phone',$data['tel'])->first();
			if(empty($tempPhone)){
				$m3_result->status = 11;
				$m3_result ->message = "重新发送验证码";
				return $m3_result->toJson();
			}
			//
			if($tempPhone->code == $data['smscode']){
				if(time()>$tempPhone->deadline){
					$m3_result->status = 12;
					$m3_result->message = "验证码过期";
					return $m3_result->toJson();
				}
				$member=array(
					'nickname'=>$data['username'],
					'phone'=>$data['tel'],
					'password'=>md5($data['password']),
					'active'=>1
				);
				$res = Member::insertGetId($member);
				if($res){
					$m3_result->status = 0;
					$m3_result->message = "注册成功";
					return $m3_result->toJson();
				}else{
					$m3_result->status = 13;
					$m3_result->message = "写入失败";
					return $m3_result->toJson();
				}
			}else{
				$m3_result->status = 13;
				$m3_result->message = "短信验证码不对";
				return $m3_result->toJson();
			}
		}
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
	 *	发送验证码
	 * @return[type][description]
	 */
	public  function sendSMS($data){

		$m3_result = new M3Result;
/*****调试****/
	//	$m3_result->status = 0;
	//	$m3_result->message = "发送成功";
	//	return $m3_result->toJson();
/*****end****/

		$moble =$data['moble'];

		$sendTemp = new SendTemplateSMS;
		$code='';
		$charset = '1234567890';
		$_len = strlen($charset) - 1;
		for($i = 0;$i < 6;++$i){
			$code .= $charset[mt_rand(0,$_len)];
		}
		$m3_result = $sendTemp->sendTemplateSMS($moble,array($code,60),1);
		if($m3_result->status ==0 )
		{
			//
			$res = TempPhone::where('phone',$moble)->delete();

			$tempPhone = new TempPhone;
			$tempPhone->phone = $moble;
			$tempPhone->code = $code;
			$tempPhone->deadline = time()+3600;//5分钟后过期
			$tempPhone->save();

			$m3_result->status = 0;
			$m3_result->message = "发送成功";
		}

		return $m3_result->toJson();
	}


	public function validateEmail( Request $res){


		$member_id = $res->input('member_id','');
		$code = $res->input('code','');
		//
		echo $member_id;
		echo "<br>" .$code;
		if($member_id == '' || $code == ''){
			return '验证异常1';
		}

		$tempEmail = TempEmail::where('member_id',$member_id)->first();
		if($tempEmail == null){
			return '验证异常2';
		}

		if($code == $tempEmail->code){
			if(time() > $tempEmail->deadline){
				return '链接失效';
			}
			$member = Member::find($member_id);
			$member->active = 1;
			$member->save();
			return redirect('login');
		}else{
			return '链接失效';
		}

	}
}
