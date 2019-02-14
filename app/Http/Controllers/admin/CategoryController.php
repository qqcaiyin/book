<?php

namespace App\Http\Controllers\Admin;


use App\Entity\Category;
use App\Entity\Product;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

////////////////视图界面/////////////////
	/**
	 * 获取分类菜单试图
	 * @return[type][description]
	 */
	public function toCategoryList(Request $request){
		$parent_id = $request->input('parent_id','');
		if($parent_id){
			$categories = Category::where('path' ,'like binary','%,' . $parent_id . ',%')->orderby('path','asc')->get();
		}else{
			$categories = Category::orderby('path','asc')->get();
		}
		//将分类数据整理排序
		foreach ($categories as $category){

			$arr = explode(',',$category->path);
			$tot = count($arr)-3;
			//if($tot){
			//	$category->name =str_repeat('|------------',1).$category->name;
			//}

			$category->tot = $tot;
			//获取父类的name
			if($category->parent_id != 0){
				$category->parent = Category::find($category->parent_id);
			}
		}
		$categories->selected = $parent_id;
		$cate = $this->_getTree();
		return view('admin/category/list')->with('categories',$categories)
											->with('cate',$cate);
	}
	/**
	 * 添加分类视图
	 * @return array
	 */
	public function tocategoryAdd(){

		$categories =$this->_getTree();
		return view('admin/category/add')->with('categories',$categories);
	}
	/**
	 * 添加子类视图
	 * @param  integer $id
	 * @return
	 */
	public function toCategoryAddson($id){

		$category = Category::find($id);
		return view('admin/category/addson')->with('category',$category);
	}

	/**
	 * 编辑分类视图
	 * @return array
	 */
	public function tocategoryEdit($id){
		//获取分类树
		$categories =$this->_getTree();
		$category = Category::find($id);
		return view('/admin/category/edit')->with('categories',$categories)
			->with('category',$category);
	}

	/**
	 * 获取分类树
	 * @return obj
	 */
	private function _getTree(){
		$categories = Category::select('id','name','parent_id','path')->orderby('path','asc')->get();
		foreach ($categories as $category){
			$arr = explode(',',$category->path);
			$tot = count($arr)-3;
			$category->name =str_repeat('|-----',$tot).$category->name;
			//$tot = (count($arr)-3)*10;
			//	$category->name =str_repeat('&nbsp;',$tot).$category->name;
		}
		return $categories;
	}
////////////////////数据处理界面///////////////////
	/**
	 * 存储添加的分类
	 * @param json
	 * @return json
	 */
	public function categoryAdd(Request $request){

		$m3_result = new M3Result;

		$data = $request->except('_token','file');
		//数据插入到数据库
		$id = Category::insertGetId($data);
		if(!$id){
			$m3_result->status = 10;
			$m3_result->message = "失败";
		}
		//获取刚插入数据的id
		$current_id =$id ;
		$parent_id = $data['parent_id'];
		$path = '0,' .$current_id .',';
		if($parent_id != 0 ){
			$pre_cate = Category::find($parent_id);
			$path = $pre_cate->path .  $current_id . ',';
		}
		//dd($path);
		//更新上条插入的数据的path字段
		$res = Category::where('id',$current_id)->update(['path'=>$path]);
		if($res){
			$m3_result->status = 0;
			$m3_result->message = "添加成功";
		}else{
			$m3_result->status = 10;
			$m3_result->message = "添加失败";
		}
		return $m3_result->toJson();
	}
	/**
	 * 存储添加的子类
	 * @param integer $id
	 * @return json
	 */
	public function categoryAddson($id){

		$category = Category::find($id);
		return view('admin/category/category_addson')->with('category',$category);
	}
	/**
	 * 删除当前类和子类
	 * 需要判断这个类别和子类下面是否有产品，有产品的话不能删除
	 * @param
	 * @return json
	 */
	public  function  categoryDel(Request $request){

		$m3_result = new M3Result;

		$total = $request->input('total','');
		$page = $request->input('page','');
		$index = strpos($page , 'page=');
		$_page = (int)substr($page,$index+5,1);//获取当前页码
		$category_id = $request->input('category_id','');

		/*这个类别和子类下面是否有产品，有产品的话不能删除*/

		//找到这个类系的所有类id
		$cate = Category::select('id')->where('path' ,'like','%,'. $category_id . ',%')->get()->toarray();
		$cate = array_column($cate,'id');
		//	查找这此类和子类下面是否有产品
		$p = Product::select('id','name','preview','price')
			->where('is_del',0)
			->wherein('category_id',$cate)
			->get()->toarray();
		if($p){
			//有产品 -不能是删除  返回信息
			$m3_result->status = 10;
			$m3_result->message = "类别或子类下有产品，不能删除";
			return $m3_result->toJson();
		}
		//删除配图
		$_image = Category::where('id',$category_id)->first();
		if(trim($_image['preview']) != ''){
			$res = file_exists('.' . $_image['preview']);
			if(!$res){
				$m3_result->status = 10;
				$m3_result->message = "删除失败";
				return $m3_result->toJson();
			}
			$_res_delImages = unlink('.' .$_image->preview);
		}else{
			$_res_delImages = 1;
		}
		//删除路径中包含此id的数据（删除当前类和子类）
		$res_delCate = Category::where('path' ,'like binary','%,' . $category_id . ',%')->delete();
		if($_res_delImages && $res_delCate){
			$m3_result->status = 0;
			$m3_result->message = "删除成功";
			$m3_result->pagenum = $_page;
		}else{
			$m3_result->status = 1;
			$m3_result->message = "删除失败";
		}

		return $m3_result->toJson();
	}
	/**
	 * 删除当前类和子类
	 * @param
	 * @return json
	 */
	public function categoryEdit( Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "更新成功";

		$name = $request->input('name','');
		$category_no = $request->input('category_no','');
		$preview = $request->input('preview','');
		$parent_id =(int)$request->input('parent_id','');
		$is_show = $request->input('is_show','');
		$summary = $request->input('summary','');
		$id = $request->input('id','');

		$category = Category::find($id);
		//分类未被修改
		if($parent_id != 100){
			$newParent='';
			if($parent_id == 0){
				$newPath ='0,';
			}else{
				$newParent = Category::find($parent_id);//修改后的父类
				//新的父类路径
				$newPath = $newParent->path;
			}
			//原来父类的路径
			$repPath = str_replace(',' . $id . ',' ,',' ,$category->path);

			$editCategories = Category::where('path' ,'like binary','%,' . $id . ',%')->get();
			foreach($editCategories as $e){
					$_path = str_replace($repPath,$newPath ,$e->path);
					$e->path = $_path;
					$e->save();
			}
		}

		$category = Category::find($id);
		$category->name = $name;
		$category->category_no = $category_no;
		$category->is_show = $is_show;
		$category->preview = $preview;
		$category->summary = $summary;
		if($parent_id != 100){
			$category->parent_id = $parent_id;
		}
		$category->save();

		return $m3_result->toJson();
	}
	/**
	 * 改变分类排序
	 * @param
	 * @return json
	 */
	public function toChangeOrder(Request $request){

		$m3_result = new M3Result;

		$id = $request->input('id','');
		$category_no =$request->input('category_no','');

		if(!is_numeric($category_no)){
			$m3_result->status = 1;
			$m3_result->message = "填写数字";
			return $m3_result->toJson();
		}
		$res = Category::where('id',$id)->update(['category_no'=>$category_no]);
		if($res){
			$m3_result->status = 0;
			$m3_result->message = "更改成功";
		}else{
			$m3_result->status = 2;
			$m3_result->message = "更改失败";
		}

		return $m3_result->toJson();

	}
	/**
	 *@param type: name  	更改产品名
	 *             order 	更改排序
	 *             is_show  上下架
	 *@param id          	类别编号
	 *@param changeValue 	新值
	 */
	public function toChangeValue(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "更改完成";

		$id = $request->input('id','');
		$tp =$request->input('tp','');
		$changeValue =$request->input('changeValue','');

		switch($tp){
			case 'name':
				if( $changeValue != '' ){
					$res_name = Category::where('id',$id)->update(['name'=>$changeValue]);
				}else{
					$m3_result->status = 10;
					$m3_result->message = "不能为空";
				}
				break;
			case 'order':
				if(is_numeric($changeValue)){
					$changeValue = $changeValue >0? ($changeValue >99? 99:$changeValue) : 0;
					if($changeValue ==99){
						$m3_result->status = 1;
					}
					if($changeValue == 0){
						$m3_result->status = 2;
					}
					$res_order = Category::where('id',$id)->update(['category_no'=>$changeValue]);
				}else{
					$m3_result->status = 11;
					$m3_result->message = "填写数字0-99";
				}
				break;
			case 'is_show':
					$category = Category::find($id);
					if($category->is_show == 0){
						$category->is_show = 1;
						$m3_result->status = 3;
						$m3_result->message = "首页显示";
					}else if($category->is_show == 1){
						$category->is_show = 0;
						$m3_result->status = 4;
						$m3_result->message = "首页不显示";
					}
					$res_show = Category::where('id',$id)->update(['is_show'=>$category->is_show]);
				break;
		}

		return $m3_result->toJson();
	}

}
