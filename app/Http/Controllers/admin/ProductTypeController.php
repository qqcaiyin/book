<?php

namespace App\Http\Controllers\Admin;


use App\Entity\Pdt_attr;
use App\Entity\Pdt_type;
use App\Entity\Product;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductTypeController extends Controller
{

////////////////////////////视图//////////////////////////////
	/**
	 * 产品类型列表视图
	 * @return[type][description]
	 */
	public function toTypeList(){

		$pdt_types = Pdt_type::orderby('id','asc')->paginate(11);

		foreach ($pdt_types as $pdt_type){
			$pdt_type->attr = Pdt_attr::where('type_id', $pdt_type->id)->where('is_use',1)->get();
		}

		return  view('admin/producttype/list')->with('pdt_types',$pdt_types);
	}
	/**
	 * 添加产品类型视图
	 * @return[type][description]
	 */
	public function toTypeAdd(){

		return view('admin/productType/add');
	}
	/**
	 * 产品类型编辑视图
	 * @paragm    $id
	 * @return[type][description]
	 */
	public function toTypeEdit($id){
		//获取id对应的类型
		$pdt_type = Pdt_type::find($id);
		//获取此类型的各个属性
		$pdt_attrs = Pdt_attr::where('type_id',$pdt_type->id)->where('is_use',1)->get();

		return  view('admin/productType/edit')->with('pdt_type',$pdt_type)
													->with('pdt_attrs',$pdt_attrs);
	}

	/**
	 *
	 * @paragm
	 * @return[type][description]
	 */

	public function toproductSearch( Request $request){
		$keyword = $request->input('keyword','');
		$products = Product::orderby('id','easc')->where('name' ,'like binary','%'.$keyword.'%')->orWhere('summary','like binary','%'.$keyword.'%')->paginate(8);
		//检索到的条数
		$total = $products->total();
		$products->count = $total;
		//搜索字描红
		$a = " <font color ='red'>$keyword</font>";
		foreach ( $products as $product ){
			$product->name = str_replace($keyword,$a,$product->name);
			$product->summary = str_replace($keyword,$a,$product->summary);
		}
		return  view('admin.product_search')->with('keyword',$keyword)
			                                      ->with('products',$products);
	}

	//////////////////////////数据处理//////////////////////////////////
	 /**
	  * 处理 【类型添加】页  添加的产品类型
	  * @paragm      type_name  产品类型名称
	  * @paragm        attr_name  产品类型->属性名称
	  * @paragm      uitype  属性展示类型
	  * 					->radio 单选   0，
	  *  					->checkbox 复选 1，
	  * 					->input  输入  2，
	  * @paragm		vallist   属性对应的选择数据
	  * @return
	  */
	public function typeAdd(Request $request){
		//返回处理的信息 josn格式
		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "添加成功";
		//获取全部数据
		$all = $request->all();
	//	dd($all);
		//获取过来的数据
		$type_name = $all['type_name'];
		$attr_names = $all['attr_name'];
		$uitypes = $all['uitype'];
		$vallists = $all['vallist'];
		$is_guige = $all['is_guige'];
		$count = count($attr_names)-1;
		//去掉每个数组的最后一元素
		array_pop($attr_names);
		array_pop($uitypes);
		array_pop($vallists);
		array_pop($is_guige);
		$count = count($attr_names);
		//	插入产品类型，并得到id值
		$id = Pdt_type::insertGetId(
			['name'=>$type_name]
		);

		for($i=0; $i<$count;$i++){
			Pdt_attr::insert([
				'type_id'=>$id ,
				'name'=>$attr_names[$i] ,
				'index'=>$uitypes[$i] ,
				'value'=>$vallists[$i] ,
				'is_guige'=>$is_guige[$i]
			]);
		}

		return $m3_result->toJson();
	}

	/**
	 *已有产品类型的编辑
	 * @paragm        type_name  产品类型名称
	 * @paragm        attr_name  产品类型->属性名称
	 * @paragm        uitype     属性展示类型
	 * 					->radio  单选   0，
	 *  				->checkbox 复选 1，
	 * 					->input  输入  2，
	 * @paragm		  vallist   属性对应的选择数据
	 * @paragm		  is_guige  属性是否设置为规格
	 * @return
	 */
	public function typeEdit(Request $request){
		//返回的信息
		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "更新成功";
		//获取全部数据
		$all = $request->all();
	//	dd($all);
		//获取过来的数据
		$id = $all['id'];
		$type_name = $all['type_name'];
		$attr_names = $all['attr_name'];
		$uitypes = $all['uitype'];
		$vallists = $all['vallist'];
		$is_guige = $all['is_guige'];
		//$count = count($attr_names)-1;
		//去掉每个数组的最后一元素
		array_pop($attr_names);
		array_pop($uitypes);
		array_pop($vallists);
		array_pop($is_guige);
		$count = count($attr_names);
		//更新类型表
		$res = Pdt_type::where('id',$id)->update(['name'=>$type_name]);
		//把id使用的属性先标记为停用
		$res = Pdt_attr::where('type_id',$id)->where('is_use',1)->update(['is_use'=>0]);
		foreach($attr_names as $key =>$attr_name){
			//查找数据库中是否有这条，有的话更新数据，没有的话插入数据
			$res = Pdt_attr::where('type_id',$id)->where('id',$key)->first();
			if($res){
				$res_attr = Pdt_attr::where('id',$key)->update([
					'name'=>$attr_names[$key],
					'index'=>$uitypes[$key],
					'value'=>$vallists[$key],
					'is_use'=>1,
					'is_guige'=>$is_guige[$key]
				]);
				if(!$res_attr){
					$m3_result->status = 11;
					$m3_result->message = "更新失败";
				}
			}else{
				$res_attr = Pdt_attr::insert([
					'type_id'=>$id,
					'name'=>$attr_names[$key],
					'index'=>$uitypes[$key],
					'value'=>$vallists[$key],
					'is_use'=>1,
					'is_guige'=>$is_guige[$key]
				]);
				if(!$res_attr){
					$m3_result->status = 11;
					$m3_result->message = "更新失败";
				}
			}
		}

		return $m3_result->toJson();
	}

	/**
	 *删除 id 对应的类型
	 * @paragm      id  产品类型编号
	 *
	 * @return
	 */
	public function typeDel(Request $request){
		//返回的信息
		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "删除成功";
		//获取提交过来的ID
		$id = $request->input('id','');
		//删除类型表对应的id数据
		$res_type = Pdt_type::where('id',$id)->delete();
		if(!$res_type){
			$m3_result->status = 10;
			$m3_result->message = "删除失败";
		}
		//删除此类型下对应的属性
		$res_attr = Pdt_attr::where('type_id',$id)->delete();
		if(!$res_attr){
			$m3_result->status = 11;
			$m3_result->message = "删除失败";
		}

		return $m3_result->toJson();
	}

	/**
	 *@param type: name  更改产品名
	 *             price 更改价格
	 *             num   更改库存
	 *             order 更改排序
	 *             is_show 上下架
	 * @param id         产品编号
	 *@param changeValue 新值
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
				if(!empty($changeValue )){
					$res_name = Product::where('id',$id)->update(['name'=>$changeValue]);
				}else{
					$m3_result->status =10;
					$m3_result->message = "不能为空";
				}
				break;
			case 'price':
				if(is_numeric($changeValue) ){
					$res_price = Product::where('id',$id)->update(['price'=>$changeValue]);
				}else{
					$m3_result->status =11;
					$m3_result->message = "填写数字";
				}
				break;
			case 'num':
				if(is_numeric($changeValue) ){
					$res_num = Product::where('id',$id)->update(['num'=>$changeValue]);
				}else{
					$m3_result->status = 12;
					$m3_result->message ="填写数字";
				}
				break;
			case 'order':
				if(is_numeric($changeValue) ){
					$changeValue = $changeValue >0? ($changeValue >99? 99:$changeValue) : 0;
					if($changeValue ==99){
						$m3_result->status = 1;
					}
					if($changeValue == 0){
						$m3_result->status = 2;
					}
					$res_order = Product::where('id',$id)->update(['sort'=>$changeValue]);
				}else{
					$m3_result->status = 13;
					$m3_result->message = "填写数字";
				}
				break;
			case 'is_show':
				$product = Product::find($id);
				if($product->is_show == 0){
					$product->is_show = 1;
					$m3_result->status = 3;
					$m3_result->message = "上架";
				}else if($product->is_show == 1){
					$product->is_show = 0;
					$m3_result->status = 4;
					$m3_result->message = "下架";
				}
				$res_show = Product::where('id',$id)->update(['is_show'=>$product->is_show]);
				break;
		}

		return $m3_result->toJson();
	}

}
