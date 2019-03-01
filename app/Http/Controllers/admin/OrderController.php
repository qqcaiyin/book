<?php

namespace App\Http\Controllers\Admin;


use App\Entity\Balance_log;
use App\Entity\Category;
use App\Entity\Member;
use App\Entity\Member_grade;
use App\Entity\Member_log;
use App\Entity\Order;
use App\Entity\Order_products;
use App\Entity\Order_return_apply;
use App\Entity\Pdt_id_attr;
use App\Entity\Return_apply_images;
use App\Entity\Return_log;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use function PHPSTORM_META\type;

use DB;
	class OrderController extends Controller
{
	/**
	 *订单列表界面   +  搜索显示
	 *
	 */
	public function toOrderList(Request $request){

		$data = $request->all();

		$where=1;
		$searchDate=array();
//判断是否搜索
		if(isset($data['is_search'])){
			//搜索订单编号
			if( ($order_sn = trim($data['order_sn'])) ){
				$where = ' order_sn=' . intval($order_sn) . '';//输入框的内容转化为整数型
			}
			//搜索会员名
			if( $nickname = trim($data['nickname']) ){
				$where .= ' and nickname like "%'.$nickname .'%" ';
			}
			//订单状态
			if($data['search_tp2'] != 10){
				$where .=  ' and  status=' .  $data['search_tp2'];
			}
			//搜索时间范围
			if($data['starttime'] &&$data['endtime']){

				$starttime = strtotime(trim($data['starttime']));
				$endtime = strtotime(trim($data['endtime']));
				$where .= ' and  add_time  between  ' . $starttime . '  and  ' . $endtime  ;
			}
			//dd($where);

			//根据搜索条件查找数据表  $where原生SQL语句
			$orderList = Order::whereRaw($where)
				->where('is_del',0)
				->leftjoin('member' ,'member.id','=','order_info.member_id')		//获取会员信息
				->leftjoin('hat_province as hp' ,'hp.id','=','order_info.province')//获取省份
				->leftjoin('status_desc as sd' ,'sd.status_id','=','order_info.status')//获取订单状态
				->leftjoin('hat_city as hc' ,'hc.id','=','order_info.city')			//获取城市
				->select('order_info.*','member.nickname','hp.province','hc.city','sd.status_name as status_name')
				->paginate(10);

			if($orderList->isempty()){
				//查询结果为空 ，直接返回
				$orderData='';
				return  view('admin/order/list',compact('orderData','orderList'));
			}

			//使用appends把参数配置上，
			//$request->input取得是url参数的值，把参数拼进去。再点击下一页的时候就链接跳转进入控制器处理，就可以获取到查询条件了。
			$search = array(
				'is_search' => 1,
				'order_sn' => trim($data['order_sn']),
				'nickname' =>trim( $data['nickname']),
				'search_tp2'=>$data['search_tp2'],
				'starttime' => $data['starttime'],
				'endtime' => $data['endtime'],
			);
			$appendData = $orderList->appends($search);

		}else{
//非搜索情况下
			$orderList =Order::orderby('order_info.id','desc')
				->where('is_del',0)
				->leftjoin('member' ,'member.id','=','order_info.member_id')		//获取会员信息
				->leftjoin('hat_province as hp' ,'hp.id','=','order_info.province')//获取省份
				->leftjoin('status_desc as sd' ,'sd.status_id','=','order_info.status')//获取订单状态
				->leftjoin('hat_city as hc' ,'hc.id','=','order_info.city')			//获取城市
				->select('order_info.*','member.nickname','hp.province','hc.city','sd.status_name as status_name')
				->paginate(10);
		}

		$orderData = array();
		foreach ($orderList as $key=>$order){
			//订单未支付，且超过1小时，取消订单
			if(($order->status == 0) && ((time() - $order->add_time) > 3600)){
				$order->status =1 ;
				$order->status_name ='订单超时';
				$_res = Order::where('id',$order->id)->update(['status'=>1]);
				if($_res){

				}
			}

			//获取订单中的产品列表
			$orderProducts = Order_products::where('order_products.order_id',$order['id'])
				->leftjoin('product' ,'product.id','=','order_products.product_id')		//获取产品信息
				->get()->toarray();

			foreach($orderProducts as &$orderProduct ){
				$attrs = explode(',', $orderProduct['product_attr'] );

				$res = Pdt_id_attr::wherein('id',$attrs)->select('attr_value')->get()->toarray();
				$orderProduct['product_attr']=implode(',',array_column($res,'attr_value'));

			}
			$orderData[$order['id']] = $order;
			$orderData[$order['id']]['pdt'] = $orderProducts;
		}

		return  view('admin/order/list',compact('orderData','orderList' ,'search'));
	}

	/**
	 *退货订单列表
	 *
	 */
	public function toReturnList(){

		$applyList = Order_return_apply::orderBy('id', 'desc')
			->leftjoin('order_products as op' ,'op.order_son_sn','=','order_return_apply.order_sn')
			->select('order_return_apply.*','op.product_id','op.product_name','op.spec_value')
			->paginate(15);
//dd($applyList);
		return view('admin/order/return_list', compact('applyList'));
	}
	/**
	 *退货订单列表
	 *
	 */
	public function toReturnDetails(Request $request){

		$data = $request->all();
		$applyList = Order_return_apply::where('order_return_apply.return_sn',$data['sn'])
			->leftjoin('order_products' ,'order_products.order_son_sn','=','order_return_apply.order_sn')
			->leftjoin('product','product.id','=','order_products.product_id')
			->leftjoin('order_return as ot','ot.return_sn','=','order_return_apply.order_sn')
			->select('order_products.*','order_return_apply.*','product.preview','ot.express_sn')
			->first()->toarray();
		$applydetails = $applyList;
		$img = Return_apply_images::where('return_sn',$data['sn'])->get()->toarray();
		$applydetails['img'] =$img;
		//dd($applydetails);
		return view('admin/order/returndetails', compact('applydetails'));
	}

	/**
	 *订单添加界面
	 *
	 */
	public function toOrderAdd(){

		return  view('admin/order/add');
	}

	/**
	 *订单详情界面
	 *
	 */
	public function toOrderInfo( Request $request){

		$do = $request->input('do');
		$order_sn = $request->input('id');

		if($do == 'details'){
			$order = Order::where('order_info.order_sn',$order_sn)
				->leftjoin('member' ,'member.id','=','order_info.member_id')		//获取会员信息
				->leftjoin('status_desc as sd' ,'sd.status_id','=','order_info.status')//获取订单状
					->select('order_info.*','sd.status_name' ,'member.nickname','member.phone as member_phone','member.email as member_email')
				->first()->toarray();
			//dd($order);

			$orderData = array();
			//获取订单中的产品列表
			$orderProducts = Order_products::where('order_products.order_id',$order['id'])
				->leftjoin('product' ,'product.id','=','order_products.product_id')		//获取产产品详细信息
				->get()->toarray();

			//获取订单中每个产品的规格
			foreach($orderProducts as &$orderProduct ) {
				$attrs = explode(',', $orderProduct['product_attr']);

				$res = Pdt_id_attr::wherein('id', $attrs)->select('attr_value')->get()->toarray();
				$orderProduct['product_attr'] = implode(',', array_column($res, 'attr_value'));
			}
			$orderData = $order;
			$orderData['pdt'] = $orderProducts;
//dd($orderProducts);
			//配送状态
			if($orderData['shipping_status'] == 0){
				$orderData['shipping_status'] = '未发货';
			}else if($orderData['shipping_status'] == 1){
				$orderData['shipping_status'] = '已发货';
			}else if($orderData['shipping_status'] == 2){
			$orderData['shipping_status'] = '已签收';
		}
			//dd($orderData);

			return view('admin/order/detail',compact('orderData'));
		}

		return view('admin/404');

	}

	public function toOrderPrint(){

		return view('admin/order/print');
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 *后台取消订单
	 *
	 */
	public function orderCancel(Request $request){

		$m3_result = new M3Result;

		$order_Sn = $request->input('order_sn');

		$res = Order::where('order_sn',$order_Sn)->update(['status'=>2]);
		if($res){
			$m3_result->status = 0;
			$m3_result->message = '订单取消成功';
		}else{
			$m3_result->status = 10;
			$m3_result->message = '订单取消失败';
		}

		return $m3_result->toJson();

	}

	/**
	 *后台删除订单
	 *
	 */
	public function orderDel(Request $request){

		$m3_result = new M3Result;

		$order_Sn = $request->input('order_sn');

		$res = Order::where('order_sn',$order_Sn)->update(['is_del'=>1]);//返回的是删除的行数
		if($res){
			$m3_result->status = 0;
			$m3_result->message = '订单删除成功';
		}else{
			$m3_result->status = 10;
			$m3_result->message = '订单删除失败';
		}

		return $m3_result->toJson();

	}

	public function orderSer(Request $request){
		$data = $request->all();
		$m3_result = new M3Result;
		$act = isset($data['act']) ? $data['act'] :'';

		if($act == 'audit_tj'){
			$m3_result->status = 0;
			$m3_result->message = '提交成功' ;

			$status = isset($data['st']) ? intval($data['st'] ):0;
			$return_sn = isset($data['sn']) ? $data['sn'] :'';
			$content = isset($data['content']) ? $data['content'] :'';

			$desc ='';
			if($status == 1){
				$desc = '审核通过，备注：'.$content   ;
			}

			$res = Order_return_apply::where('return_sn',$return_sn)->update([
				'status'=> $status,
				'audit_why' => $content,
				'audit_time' => time(),
			]);
			if(!$res){
				$m3_result->status = 10;
				$m3_result->message = '重新提交' ;
				return $m3_result->toJson();
			}
			$res = Return_log::insertGetId([
				'return_sn' => $return_sn,
				'party'=>1,
				'desc' =>$desc,
				'time'=>time(),
			]);
			if(!$res){
				$m3_result->status = 10;
				$m3_result->message = '重新提交' ;
			}
			return $m3_result->toJson();
		}else if(  $act == 'audit_sign'){
//退换货  卖家签收
			$return_sn = isset($data['sn']) ? $data['sn'] :'';
			if($return_sn == ''){
				$m3_result->status = 10;
				$m3_result->message = '编号出错' ;
				return $m3_result->toJson();
			}
			//更新状态
			$res = Order_return_apply::where('return_sn',$return_sn)->update(['shipping_status'=>2]);
			dd($res);
			if(!$res){
				$m3_result->status = 10;
				$m3_result->message = '刷新后，重新签收';
			}

			$m3_result->status = 0;
			$m3_result->message = '已签收' ;
			return $m3_result->toJson();


		}



}

}