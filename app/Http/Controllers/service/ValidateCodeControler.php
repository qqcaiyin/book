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

	public  function sendSMS(Request  $res){

		$m3_result = new M3Result;

		$phone =$res->input('phone','');
		if($phone == ''){
			$m3_result->status = 1;
			$m3_result->message = "手机号不能为空";
			return $m3_result->toJson();
		}
		if(strlen($phone) != 11 || $phone[0] != '1') {
			$m3_result->status = 2;
			$m3_result->message = '手机格式不正确';
			return $m3_result->toJson();
		}

			$tempPhone = TempPhone::where('phone', $phone)->first();
			if($tempPhone == null) {

				$sendTemp = new SendTemplateSMS;
				$code='';
				$charset = '1234567890';
				$_len = strlen($charset) - 1;
				for($i = 0;$i < 6;++$i){
					$code .= $charset[mt_rand(0,$_len)];
				}
				$m3_result = $sendTemp->sendTemplateSMS($phone,array($code,60),1);
				if($m3_result->status ==0 )
				{
					$tempPhone = new TempPhone;
					$tempPhone->phone = $phone;
					$tempPhone->code = $code;
					$tempPhone->deadline = time()+3600;//5分钟后过期
					$tempPhone->save();
				}
			}else{
				$m3_result->status = -1;
				$m3_result->message = '手机号已注册';
				return $m3_result->toJson();
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
