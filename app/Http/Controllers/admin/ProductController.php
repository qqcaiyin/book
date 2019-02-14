<?php

namespace App\Http\Controllers\Admin;


use App\Entity\Category;
use App\Entity\Pdt_attr;
use App\Entity\Pdt_content;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_images;
use App\Entity\Pdt_type;
use App\Entity\Product;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class ProductController extends Controller
{

	/**
	 * is_search 0  产品列表视图；
	 * is_search 1  搜索结果视图；
	 * is_del 1 	表示在回收站中
	 * @return array
	 */
	public function toProductList( Request $request){

		$data= $request->all();
		$where =1;
//判断是否点击搜索了
		if(isset($data['is_search'])){
			if ($data['search_tp1'] == 0) {
				$where = ' p.is_new=1';//选择检索新品
			} else if ($data['search_tp1'] == 1) {
				$where = ' p.is_hot=1';//选择检索热卖
			} else if ($data['search_tp1'] == 2) {
				$where = ' p.is_best=1';//选择检索精品
			}
			if ($data['search_tp2'] != 2) {
				$where .= ' and  p.is_show=' . $data['search_tp2']; //选择检索下架/上架
			}
			if (!empty($data['keywords'])) {
				$where .= ' and p.name like "%' . trim($data['keywords']) . '%" ';
			}
			if ($data['category_id'] != 0) {
				$where .= ' and c.path like "%,' .trim( $data['category_id']) . ',%"';
			}
			//查找满足条件的数据
			$products = DB::table('product as p')
				->leftjoin('category as c', 'p.category_id', '=', 'c.id')
				->select('p.*')
				->whereRAW($where)
				->where('is_del', 0)
				->orderby('id', 'desc')
				->paginate(10);
			//搜索分页时追加的搜索条件
			$appendData = array(
				'is_search' => 1,
				'search_tp1' => $data['search_tp1'],
				'search_tp2' => $data['search_tp2'],
				'category_id' => $data['category_id'],
				'keywords' => trim($data['keywords'])
			);
			$products->appends($appendData);
			//用于回显
			$products->search = $appendData;
		}else{
//非搜索情况，获取产品的数据
			$products = Product::where('is_del',0)->orderby('id','desc')->paginate(10);
		}
		//获取每个产品对应的父类列表
		$_cate = array();
		foreach ($products as $product) {
			if ($product->category_id != 0) {
				$category = Category::find($product->category_id);
				$_cate = explode(',', $category->path);
				array_shift($_cate);
				array_pop($_cate);
				$product->category = Category::whereIn('id', $_cate)->get();
			}
		}
		//获取下拉分类栏
		$cate = $this->_getTree();
		return  view('admin/product/list' ,compact('products','cate'));
	}

	/**
	 * 垃圾箱视图
	 * @return
	 */
	public function toRecycle(){
		$products = Product::where ('is_del',1)->get();
		$_cate = array();
		foreach ($products as $product){
			$category = Category::find($product->category_id);
			$_cate = explode( ',', $category->path);
			array_shift($_cate);
			array_pop($_cate);
			$product->category = Category::whereIn('id',$_cate)->get();
		}
		return view('admin/product/recycleList')->with('products',$products);

	}

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
	/**
	 * 进入产品添加界面
	 * 将分类数据和 类型数据传过去
	 * @return
	 */
	public function toproductAdd(){
		//获取分类树
		$categories = $this->_getTree();
		//获取类型数据
		$pdt_types = Pdt_type::all();

		return view('admin/product/add')->with('categories',$categories)
												->with('pdt_types',$pdt_types);
	}



	public function toproductInfo( Request $request){
		$id =$request->input('id','');
	    $product = Product::find($id);
	    $product->category = Category::find($product->category_id);
		$pdt_content = Pdt_content::where('product_id',$id)->first();
	    $pdt_images = Pdt_images::where('product_id',$id)->get();

	  return  view('admin.product_info')->with('product',$product)
		  										->with('pdt_content',$pdt_content)
		  											->with('pdt_images',$pdt_images);
   }
	/**
	 * 产品类型勾选后的填充页面
	 *
	 * 若是产品编辑界面，需要在属性里勾选原本设置的属性
	 * @return
	 */
   public function toAttributes( Request $request){

		//获取被选中的产品类型type_id;
		$id =  $request->input('id','');
		//获取type_id 对应的属性值
	   $pdt_attrs = Pdt_attr::where('type_id',$id)->get();

	   foreach($pdt_attrs as $key=>$pdt_attr){
	   	if($pdt_attr->index <2){
	   		//$pdt_attr->index 0是下拉框， 1是复选框 ， 2是输入框
	   		//把汉字的逗号替换成英文的
			$arr = str_replace('，',',',$pdt_attr->value);
			//字符串按逗号分割成数组
			$pdt_attr->arr = explode(',',$arr);
		}else{
	   		//获取输入框的内容
			//$val = Pdt_id_attr::where('attr_id',$pdt_attr->id)->first();
			//$pdt_attr->id_value = $val;

			//test
			$pdt_attr->id_value = $pdt_attr->value;
		}
	   }
 //dd($pdt_attrs);
	   //获取要编辑的产品号
	   $arr =array();
	   $product_id = $request->input('product_id','');
	   if(!empty($product_id)){

		   $pdt_id_attr = Pdt_id_attr::where('product_id',$product_id)->get();
		   foreach ($pdt_id_attr as $key =>$p){
		   	if($p)
			   $arr[$p->attr_id][]=$p->attr_value;

		   }
		 //  dd($arr);
		   return  view('admin/product/attributes')->with('pdt_attrs',$pdt_attrs)
			   ->with('pdt_id_attr',$pdt_id_attr)
			   ->with('arr',$arr);
	   }
		return  view('admin/product/attributes')->with('pdt_attrs',$pdt_attrs)
			->with('arr',$arr);
   }

	/**
	 * 产品编辑界面
	 * 读取			produt         产品表
	 * 				category      分类表
	 * 				pdt_images    产品相册
	 * 				pdt_content	  产品详情
	 * 				pdt_id_attr	  产品属性
	 * @return
	 */
	public function toproductEdit( Request $request){

		$id = $request->input('id','');
		$product = Product::find($id);
		//获取下拉分类栏
		$cates = $this->_getTree();
		//获取类型表
		$pdt_types = Pdt_type::all();
		//获取产品相册
		$pdt_images = Pdt_images::where('product_id',$id)->get();
		//获取产品详情
		$pdt_content = Pdt_content::where('product_id',$id)->first();
		//获取产品属性
		$pdt_id_attrs = Pdt_id_attr::where('product_id',$id)->get();
//转化为数组
		$data = array(
			'product'=>$product,
			'cates'=>$cates,
			'pdt_types'=>$pdt_types,
			'pdt_images'=>$pdt_images,
			'pdt_content'=>$pdt_content,
			'pdt_id_attrs'=>$pdt_id_attrs
		);
	/*
		return  view('admin/product/edit')->with('data',$data);
	*/
		return  view('admin/product/edit')->with('product',$product)
												->with('cates',$cates)
												 ->with('pdt_types',$pdt_types)
												  ->with('pdt_images',$pdt_images)
												   ->with('pdt_content',$pdt_content)
												    ->with('pdt_id_attrs',$pdt_id_attrs);

	}

	/**
	 * 产品SKU设置界面
	 *
	 * @return
	 */
	public function toProductSku(Request $request){

		$id =$request->input('id');
		//查询产品明细
		$product = Product::select('id','name','product_sn')->find($id);

		//获取产品的规格属性
		$data =DB::select("select pia.id, pia.product_id ,  pia.attr_id ,pia.attr_value,pa.name from pdt_id_attr as pia inner join pdt_attr as pa  on pia.attr_id=pa.id where pa.is_guige =1 and  pia.product_id =". $id);
		if(!$data){
			//dd($data);
			$product->flag =0;
			return view('admin/product/sku', compact('product'));
		}
		else{
			$product->flag = 1;
		}
		//查看该产品是否设置过sku
		$pdtSkus = DB::table('pdt_sku')->where('product_id',$id)->get();
		foreach ($pdtSkus as $key=>$pdtSku){
			$pdtSku->sku_attr = explode(',', $pdtSku->sku_attr);
		}
		//dd($pdtSkus);
		//整合数据
		$productSku =array();
		foreach ($data as $key=>$value){
			$productSku[$value->attr_id]['name']=$value->name;
			$productSku[$value->attr_id]['value'][$value->id]=$value->attr_value;
		}

//dd($productSku);
		return view('admin/product/sku', compact('product','pdtSkus','productSku'));
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
			$category->name =str_repeat('|----',$tot).$category->name;
		}
		return $categories;
	}

	///////////////////////////////////////////////////////////////////////////



	/**
	 * 产品添加，数据处理
	 * 需要更新的表  produt         产品表
	 * 				pdt_images    产品相册
	 * 				pdt_content	  产品详情
	 * 				pdt_id_attr	  产品属性
	 * @return
	 */
	public function productAdd(Request $request)
	{

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "添加成功";

		//读取product表所需的数据
		$product = $request->except(['_token', 'imgs', 'attr', 'product_content', 'file']);
		//处理促销时间的格式
		$product['start_date'] = strtotime(trim($product['start_date']));
		$product['end_date'] =strtotime(trim($product['end_date']));
dd($product);
		//写入数据，返回id
		$id = Product::insertGetId($product);

		//读取添加的图片路径，写入pdt_images表中
		$imgs = $request->input('imgs');
		if($imgs){
			foreach ($imgs as $key => $img) {
				if (!empty($img)) {
					$res = Pdt_images::insert([
						'product_id' => $id,
						'image_path' => $img,
						'image_no' => $key
					]);
					if (!$res) {
						$m3_result->status = 10;
						$m3_result->message = "添加图品失败";
					}
				}
			}
		}

		//读取产品详情 写入pdt_content表中
		$content = $request->input('product_content');
		if(!empty($content)){
			$res = Pdt_content::insert([
				'product_id' => $id,
				'content' => $content
			]);
			if (!$res) {
				$m3_result->status = 11;
				$m3_result->message = "添加详情失败";
			}
		}

		//读取产品对应的属性，存表pdt_id_attr
		$attrs = $request->input('attr');
		if(!empty($attrs))
		{
			if (is_array($attrs)) {
				foreach ($attrs as $key => $attr) {
					if (is_array($attr)) {
						foreach ($attr as $a) {
							if (!empty($a)) {
								$res = Pdt_id_attr::insert([
									'product_id' => $id,
									'attr_id' => $key,
									'attr_value' => trim($a),
								]);
								if (!$res) {
									$m3_result->status = 12;
									$m3_result->message = "产品属性添加失败";
								}
							}

						}
					} else {
						$res = Pdt_id_attr::insert([
							'product_id' => $id,
							'attr_id' => $key,
							'attr_value' => $attr
						]);
						if (!$res) {
							$m3_result->status = 12;
							$m3_result->message = "产品属性添加失败";
						}
					}

				}
			}
		}

		return redirect('admin/product');
	}

	/**
	 * 产品编辑界面，数据处理
	 * 需要更新的表  produt         产品表
	 * 				pdt_images    产品相册
	 * 				pdt_content	  产品详情
	 * 				pdt_id_attr	  产品属性
	 * @return
	 */
	public function productEdit(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "添加成功";

		//获取产品id
		$product_id = $request->input('pid');
		//获取产品表的数据
		$product = $request->except(['_token','pid','img','attr','product_content','file']);
		//时间转化为时间戳
		$product['start_date'] = strtotime(trim($product['start_date']));
		$product['end_date'] = strtotime(trim($product['end_date']));

//dd($product);
		//更新数据，把那个返回id
		$res = Product::where('id',$product_id)->update($product);

		//读取添加的图片路径，写入pdt_images表中
		$imgs = $request->input('img');
		foreach ($imgs as $key=>$img) {
			if (!empty($img)) {
				$res = Pdt_images::insert([
					'product_id' => $product_id,
					'image_path' => $img,
					'image_no' => $key
				]);
			}
		}
		//更新产品详情pdt_content表
		$content = $request->input('product_content');
		$res = Pdt_content::where('product_id',$product_id)->update([
			'product_id'=>$product_id,
			'content'=>$content
		]);
		//清空产品对应的原属性表数据
		$res = Pdt_id_attr::where('product_id',$product_id)->delete();
		//读取产品对应的属性，更新pdt_id_attr
		$attrs = $request->input('attr');
		if(is_array($attrs))
		{
			foreach($attrs  as $key=>$attr){
				if(is_array($attr)){
					foreach($attr as $a){
						if(!empty($a)){
							$res = Pdt_id_attr::insert([
								'product_id'=>$product_id,
								'attr_id'=>$key,
								'attr_value'=>$a
							]);
						}
					}
				}else{
					$res = Pdt_id_attr::insert([
						'product_id'=>$product_id,
						'attr_id'=>$key,
						'attr_value'=>$attr
					]);
				}

			}
		}
		return redirect('admin/product');
	}

	/**
	 * @list页的删除->到垃圾箱：is_del 字段设置为1
	 * @recylelist页->删除：从数据库移除
	 *             ->还原： is_del 字段设置为0
	 * @param idArry 多选框的
	 * @param product_id x
	 * @param select:delete:彻底删除；recovery:还原
	 * @param select:delete    彻底删除时，需要把产品表、产品详情表、产品图片表对应的数据删除
	 * @return[type][description]
	 */
	public  function  ProductDel(Request $request){
		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "删除成功";

		$idArray = array();
		$idArray = $request->input('idArray','');
		$select = $request->input('select','');

		if($select == "recovery") {
			$res = Product::whereIn('id',$idArray )->update(['is_del'=>0]);
		}elseif($select == "delete"){
			if(count($idArray) == 1){
				$res = Product::where('id',$idArray )->delete();
				$res = Pdt_content::where('product_id',$idArray)->delete();//删除产品详情表
				$res = Pdt_images::where('product_id',$idArray)->delete();//删除产品图片表
			}else{
				$res = Product::whereIn('id',$idArray )->delete();
				$res = Pdt_content::whereIn('product_id',$idArray)->delete();//删除产品详情表
				$res = Pdt_images::whereIn('product_id',$idArray)->delete();//删除产品图片表
			}

		}elseif($select == "torecycle"){
			if(count($idArray) == 1){
				$res = Product::where('id', $idArray)->update(['is_del'=>1]);
			}else{
				$res = Product::whereIn('id', $idArray)->update(['is_del'=>1]);
			}
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
				if( $changeValue != '' ){
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

	/**
	 * 产品SKU表单的提交处理
	 *
	 * @return
	 */
	public function getSku(Request $request){

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "更改完成";

		$data = $request->all();
		$product_id = $data['product_id'];
		$sku_attr = $data['sku_attr'];
		$sku_sn = $data['sku_sn'];
		$sku_price = $data['sku_price'];
		$sku_num = $data['sku_num'];
		$count = count($sku_sn)-1;

		//去掉每个数组的最后一元素
		array_pop($sku_attr);
		array_pop($sku_sn);
		array_pop($sku_price);
		array_pop($sku_num);

		//删除旧的数据
		DB::table('pdt_sku')->where('product_id',$product_id)->delete();

		//逐条插入新数据
		for($i=0; $i<$count;$i++){
			$res = DB::table('pdt_sku')->insertGetId([
				'product_id'=>$product_id ,
				'sku_sn'=>$sku_sn[$i] ,
				'sku_price'=>$sku_price[$i] ,
				'sku_num'=>$sku_num[$i] ,
				'sku_attr'=>$sku_attr[$i *2]. ',' .$sku_attr[$i *2+1],
			]);
			if(!$res){
				$m3_result->status = 10;
				$m3_result->message = "更改失败";
			}
		}

		return  $m3_result->toJson();

	}
}
