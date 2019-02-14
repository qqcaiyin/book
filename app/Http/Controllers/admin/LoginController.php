<?php

namespace App\Http\Controllers\Admin;



use App\Entity\Order;
use App\Entity\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tool\SMS\SendTemplateSMS;
use App\Entity\TempPhone;
use App\Entity\Member;
use App\Entity\TempEmail;
use App\Models\M3Result;
use App\Models\M3Email;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Tool\Validatecode\Code;
use App\Tool\UUID;
use DB;
use Prophecy\Exception\Prediction\AggregateException;

class LoginController extends Controller
{


//select * from privillage as p INNER JOIN node as n on p.node_id = n.id

//where p.role_id in( select role_id  from admin_role as ar where ar.admin_id=11  )

	public function register(Request $res){
		$email = $res->input('email','');
		$phone = $res->input('phone','');
		$password = $res->input('password','');
		$confirm = $res->input('confirm','');
		$phone_code = $res->input('phone_code','');
		$validate_code = $res->input('validate_code','');
		$m3_result = new M3Result;

		if($email == '' && $phone == ''){
			$m3_result->status = 1;
			$m3_result ->message = "手机号或者邮箱不能为空";
			return $m3_result->toJson();
		}
		if($password == '' && strlen($password ) < 6){
			$m3_result->status = 2;
			$m3_result ->message = "密码不少于6位";
			return $m3_result->toJson();
		}
		if($confirm == '' && strlen($confirm ) < 6){
			$m3_result->status = 3;
			$m3_result ->message = "确认密码不少于6位";
			return $m3_result->toJson();
		}
		if($password != $confirm){
			$m3_result->status = 4;
			$m3_result ->message = "两次密码不一致";
			return $m3_result->toJson();
		}

// 手机号注册
		if($phone != '') {
			if($phone_code == '' || strlen($phone_code) != 6) {
				$m3_result->status = 5;
				$m3_result->message = '手机验证码为6位';
				return $m3_result->toJson();
			}
			$tempPhone = TempPhone::where('phone',$phone)->first();
			if(empty($tempPhone)){
				$m3_result->status = 6;
				$m3_result ->message = "重新发送验证码";
				return $m3_result->toJson();
			}

			if($tempPhone->code == $phone_code) {
				if (time() > $tempPhone->deadline) {
					$m3_result->status = 7;
					$m3_result->message = "验证码过期";
					return $m3_result->toJson();
				}
				$member = new Member;
				$member->phone = $phone;
				$member->password = md5( + $password);
				$member->save();

				$m3_result->status = 0;
				$m3_result->message = "注册成功";
				return $m3_result->toJson();
			}else{
				$m3_result->status = 8;
				$m3_result->message = "手机验证码不对";
				return $m3_result->toJson();
			}


		}else{
			if($validate_code == '' || strlen($validate_code) != 4) {
				$m3_result->status = 9;
				$m3_result->message = '验证码为4位';
				return $m3_result->toJson();
			}
			//有注册时的验证码
			$_mmcode = Session::get('code');

			if(strtoupper($validate_code) != $_mmcode ) {
				$m3_result->status = 10;
				$m3_result->message = '验证码不正确';
				return $m3_result->toJson();
			}

			$tempmember = Member::where('email',$email)->first();

			if(!empty($tempmember)){
				$m3_result->status = 11;
				$m3_result ->message = "用户已注册";
				return $m3_result->toJson();
			}

			$member = new Member;
			$member->email = $email;
			$member->password = md5($password);
			$member->save();

			$uuid = UUID::create();

			//邮箱验证
			$m3_email = new M3Email;
			$m3_email->to = $email;
			$m3_email->cc = '530667695@qq.com';
			$m3_email->subject = '个人书店内容';
			$m3_email->content = ' 请于24小时内完成该链接的验证。http://book.com/service/validate_email'
			                     . '?member_id='.$member->id
				                  . '&code=' . $uuid;

			Mail::send('email_register',
				 ['m3_email' => $m3_email],
				function($m) use($m3_email){
					$m->to($m3_email->to,'尊敬的用户')
						->cc($m3_email->cc)
						->subject($m3_email->subject);
			});
			$tempEmail = new TempEmail;
			$tempEmail->member_id = $member->id;
			$tempEmail->code = $uuid;
			$tempEmail->deadline = time()+24*60*60;
			$tempEmail->save();
		}
		$m3_result->status = 0;
		$m3_result->message = "注册成功";
		return $m3_result->toJson();
	}

	function inputCheck($data){
		foreach($data as $key =>&$d){
			$d = trim($d);
			$d = stripslashes($d);
			$d = htmlspecialchars($d);
		}
		return $data;
	}

	//简易的登陆
	public function adminlogin(Request $res){


		$data = $res->except('_token');
		//去掉输入的空格等
		$data = $this->inputCheck($data);
		$username = $data['username'];
		$password = $data['password'];
		//$validate_code = $res->get('validate_code','');

		$m3_result = new M3Result;

		$rules=[
			'username'=>'required',
			'password'=>'required'
		];
		$message = [
			'username.required'=>'账号不能为空',
			'password.required'=>'密码不能为空',
		];
		$validator = Validator::make($data,$rules,$message);
		if($validator->passes()){
			$res = DB::table('admin')
				->where('name',$username)
				->where('password',md5($password))
				->get();
			if($res ){
				//存到session
				Session::put('admin',$username);
				//获取登陆的时间
				$last_time = time();
				//获取登陆用户的IP
				$last_ip =$_SERVER['REMOTE_ADDR'];

				$res = DB::table('admin')->where('name',$username)->update([
					'last_time'=>$last_time,
					'last_ip'=>$last_ip
				]);
				//查看配置文件是否开启权限
				$rbac_open = config('config.RBAC_OPEN');
				Session::put('rbac_open',$rbac_open);

				//获取当前用户的权限
				$privillage = DB::select("
										select  DISTINCT(node_id),title,  controller, action   from privillage as p 
										INNER JOIN node as n on p.node_id = n.id
										where p.role_id in( select role_id  from admin_role as ar where ar.admin_id=13
										) ");
				//整理数据
				$admin_info =array();
				foreach ($privillage as $key =>$af){
					$admin_info[0][$key]=$af->controller;
					$admin_info[1][$key]=$af->action;
					$admin_info[2][$key]=$af->title;
				}

				//将当前登陆的管理员的权限存到session中
				Session::put('admin_info',$admin_info);
				$m3_result->status = 0;
				$m3_result->message = "！";
				return $m3_result->toJson();
				//return redirect('admin/index');

			}else{
				$m3_result->status = 10;
				$m3_result->message = "用户或密码不正确";
				return $m3_result->toJson();
			}
		}else{
			$m3_result->status = 11;
			$m3_result->message = "不能为空";
			return $m3_result->toJson();
		}
	}

	public function index(Request $request){
		//取出当前的登陆账号
		$username = Session::get('admin');
		return view('admin/index',compact('username'));
	}

	//权限限制和 ，禁止访问页面 ，简易版
	public function  error_404(){
		return view('admin/404');
	}

	//退出管理员账户
	public function out(){

		Session::put('admin','');
		Session::put('admin_info','');
		return redirect('admin/login');
	}

	//info 页面
	public function toInfo(){


		$memberTotal = Member::count();
		$orderTotal = Order::count();
		$productTotal = Product::count();

		//最新待处理的10个订单
		$orderList = Order::orderby('id','desc')
			->leftjoin('status_desc as sd' ,'sd.status_id','=','order_info.status')//获取订单状
			->select('order_info.*','sd.status_name')
			->take(10)->get()->toarray();

		$data = array(
			'memberTotal' =>$memberTotal,
			'productTotal' =>$productTotal,
			'orderTotal' =>$orderTotal,
			'orderList'=>$orderList,
		);

		return view('admin/info',compact('data'));
	}

}
