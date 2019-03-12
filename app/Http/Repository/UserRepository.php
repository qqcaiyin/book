<?php
/**
 * Created by PhpStorm.
 * User: jcf
 * Date: 2019/3/2
 * Time: 14:46
 */

namespace  App\Http\Repository;

use App\Entity\Member;

class UserRepository{

	protected  $user;

	public function __construct( Member $user){
		$this->user = $user;
	}

	public function getUserById($userId){
		return $this->user->where('id',$userId)->first();
	}


}


