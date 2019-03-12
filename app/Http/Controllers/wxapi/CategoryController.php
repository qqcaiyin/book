<?php

namespace App\Http\Controllers\Wxapi;

use App\Entity\Category;
use App\Http\Repository\UserRepository;
use App\Http\Requests\AddrRequest;




use DB;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{

	public function __construct()
	{

	}


	/**
	 * 分类目录
	 *
	 * @return
	 */
	public function getCategoryList( Request $request){
		$pid= $request->input('pid');

		$parentCategory = Category::getParentCategory();
		$currentCategory = Category:: getChildrenCategoryByParentId($pid);
		$data =[
			'navList' => $parentCategory,
			'currentNav' => $currentCategory

		];
		return $this->respondWithSuccess($data);

	}

	/**
	 * 获取子分类
	 *
	 * @return
	 */
	public function getCategoryByParentId( Request $request){
		$pid= $request->input('pid');
		$currentCategory = Category:: getChildrenCategoryByParentId($pid);

		return $this->respondWithSuccess($currentCategory);

	}


}
