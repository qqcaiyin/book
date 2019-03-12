<?php

namespace App\Http\Controllers\Wxapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;


class ApiController extends Controller
{

	/**
	 * 返回数据
	 * @param string $message
	 * @return \Illuminate\Http\Response
	 */

	protected function respondWithSuccess($data, $message='',$code=200, $status = 'success'  ){
		return new Response(json_encode([
					'status' => $status,
					'code' =>$code,
					'message' => $message,
					'result' => $data
				]));
	}

	/**
	 * 响应成功
	 * @param string $message
	 * @return \Illuminate\Http\Response
	 */
	protected function success($message='',$code=200, $status = 'success'  ){
		return new Response(json_encode([
			'status' => $status,
			'code' =>$code,
			'message' => $message,
		]));
	}

	/**
	 * 响应错误
	 * @param string $message
	 * @param int $code
	 * @param string $status
	 * @return Response
	 */
	protected function failed($message = '', $code = 404, $status = 'error')
	{
		return new Response(json_encode([
			'status' => $status,
			'code' => $code,
			'message' => $message,
		]));
	}

	/**
	 * 用户输入过滤
	 * @return
	 */
	protected function requestCheck($data){
		foreach($data as $key =>&$d){
			if(is_array($d)){
				$this->inputCheck($d);
			}else{
				$d = trim($d);
				$d = stripslashes($d);
				$d = htmlspecialchars($d);
			}
		}
		return $data;
	}

}
