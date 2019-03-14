<?php

namespace App\Http\Controllers\Wxapi;

use App\Entity\Category;
use App\Entity\Member_addr;
use App\Entity\Member_wx;
use App\Enum\ScopeEnum;
use App\Http\Repository\CartRepository;
use App\Http\Requests\AddrRequest;


use App\Http\Requests\TokenGetRequest;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TokenController extends ApiController
{

//"session_key" => "W3bCTfntIZoyYOVFB6YJ9A=="
//"openid" => "oYVOf4j5xmV_2_7Fv0shFvoPL1zk"


	protected $code;
	protected $wxAppId;
	protected $wxAppSecert;
	protected $wxLoginUrl;

	 public function __construct(){
	 	$this->wxAppId = config('wx.app_id');
		 $this->wxAppSecert = config('wx.app_secret');

	}

	/**
	 *微信小程序请求接口
	 * @return
	 */
	public function  getToken(TokenGetRequest $request){

		$data = $this->requestCheck($request->all());

		$this->code = $data['code'];
		$this->wxLoginUrl = sprintf(config('wx.login_url'),$this->wxAppId,$this->wxAppSecert,$this->code );
		$resData = $this->curl_get($this->wxLoginUrl);
		$token = $this->grandToken($resData);

		return $this->respondWithSuccess($token);
	}

	//生成token  保存到缓存中
	private function grandToken($wxResult){
		$openid = $wxResult['openid'];
		$user = Member_wx::getByOpenId($openid);

		if($user){
			$uid = $user->id;
		}else{
			$uid = Member_wx::insertGetId(['openid'=>$openid]);
		}

		$cacheValue = $this->cacheValue($wxResult ,$uid);
		$token = $this->saveToCache($cacheValue);
		return $token;
	}


	//保存缓存中
	private function saveToCache($cacheValue){

		$key =$this->generateToken();
		$value = json_encode($cacheValue);
		$expire = Carbon::now()->addMinutes(30);
		Cache::put($key, $value,$expire);

		return  $key;

	}

	//
	private  function cacheValue( $wxResult ,$uid){

		$cacheValue = $wxResult;
		$cacheValue['uid'] = $uid;
		$cacheValue['scope'] = ScopeEnum::User;
		return $cacheValue;

	}



}
