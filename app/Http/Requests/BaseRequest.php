<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

 class BaseRequest extends FormRequest
{
    //
/*
	protected function failedValidation(Validator $validator) {
		$error= $validator->errors()->all();
		throw new HttpResponseException(response()->json(['message'=>$error[0],'code'=>'500'], 500));

	}

*/



}
