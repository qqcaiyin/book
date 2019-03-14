<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

use Validator;
use App\Http\Providers\AppServiceProvider;

class AddrRequest extends FormRequest
{

    //
	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'consignee' => 'sometimes|required',
			'moble' => 'sometimes|required|telphone',
			'district' => 'sometimes|required',
			'token' => 'required',
		];
		return $rules;
	}

	public function messages(){
		$message = [
			'consignee.required' => '收件人参数缺失',
			'moble.required' => '收件人手机号参数缺失',
			'moble.telphone' => '手机号码格式不对',
			'district.required' => '详细地址参数缺失',
			'token.required' => 'token缺失',
		];
		return $message;
	}

}
