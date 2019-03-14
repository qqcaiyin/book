<?php
/**
 * Created by PhpStorm.
 * User: jcf
 * Date: 2019/3/2
 * Time: 14:46
 */

namespace  App\Http\Repository;

use App\Entity\Member;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Cache;

class UserRepository{

	protected  $user;

	public function __construct( Member $user){
		$this->user = $user;
	}


	//根据用户Id获取用户信息
	public function getUserById($userId){
		return $this->user->where('id',$userId)->first();
	}


	//检测token对应的 uid;
	public  function getCurrentTokenVar($token ,$key = 'uid'){

		$vars = json_decode(Cache::get($token) ,true);
		if(!$vars){
			throw new ApiException("token错误");
		}
		if(!array_key_exists($key,$vars)){
			throw new ApiException("token异常");
		}
		return $vars[$key];
	}

}


