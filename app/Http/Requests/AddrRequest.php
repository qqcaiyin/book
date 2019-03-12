<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class AddrRequest extends FormRequest
{

    //
	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'id' => 'sometimes|required|int',
			'consignee' => 'sometimes|required|',
			'phone' => 'sometimes|required|',
			'district' => 'sometimes|required|',

		];
		return $rules;
	}

	public function messages(){
		$message = [
			'id.required' => 'id异常',
			'consignee.required' => '收件人参数缺失',
			'phone.required' => '收件人手机号参数缺失',
			'district.required' => '详细地址参数缺失',
		];
		return $message;
	}

}
