<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

 class BaseRequest extends FormRequest
{
    //

	protected function failedValidation(Validator $validator) {
		$error= $validator->errors()->all();
		throw new HttpResponseException(response()->json(['msg'=>'验证不通过','code'=>'500','data'=>$error[0]], 500));

	}





}
