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
	public function requestCheck($data){

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

	//读取接口
	public function curl_get($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$result = curl_exec($ch);
		$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);
		$data = json_decode($result,true);
		return $data;
	}

	//获取随机TOKEN
	public function generateToken(){
		$randChars = $this->getRandChar(32);
		return $randChars;
	}

	//获取指定长度的随机字符串
	public  function getRandChar($length){
		$str = null;
		$strPol = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
		$max = strlen($strPol) -1;

		for($i= 0; $i < $length; $i++){
			$str .= $strPol[rand(0,$max)];
		}
		return $str;
	}


}
