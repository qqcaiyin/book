<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

use Validator;

class TokenGetRequest extends FormRequest
{

    //
	public function authorize(){
		return true;
	}

	public function rules(){
		$rules = [
			'code' => 'required',
		];
		return $rules;
	}

	public function messages(){
		$message = [
			'id.required' => 'code不能为空',
		];
		return $message;
	}

}
