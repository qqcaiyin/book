<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

use Validator;
use App\Http\Providers\AppServiceProvider;

class BuyNowRequest extends FormRequest
{

    //
	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'id' => 'required|numeric',
			'number' => 'required|numeric',
			'addressId' => 'sometimes|required|numeric',
			//'spec' => 'sometimes|required',
			'token' => 'sometimes|required',
		];
		return $rules;
	}

	public function messages(){
		$message = [
			'id.required' => '产品id不能为空',
			'number.required' => '购买数量不能为空',
			'number.numeric' => '购买数量格式不对',
			'addressId.required' => '地址id不能为空',
			'addressId.numeric' => '地址id异常',
			'token.required' => 'token缺失',
		];
		return $message;
	}

}
