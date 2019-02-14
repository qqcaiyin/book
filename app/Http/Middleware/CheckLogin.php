<?php

	namespace App\Http\Middleware;

	use App\Http\Requests\Request;
	use Closure;
	use Illuminate\Support\Facades\Session;


	class CheckLogin
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request  $request
		 * @param  \Closure  $next
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{
			//获取上一次访问的地址
		//	$http_refer = $_SERVER['HTTP_REFERER'];
			//	return redirect('/login?return_url' .urlencode($http_refer) );
			 //$member = $request->session()->get('admin','');

			$member =Session::get('admin');

			if($member == ''){

			//	return redirect('/login?return_url' .urlencode($http_refer) );
				return redirect('/admin/login');
			} else{

				//RBAC_OPEN 配置，true表示开启
				$rbac_open = config('config.RBAC_OPEN');
				//	dd($rbac_open);
				//权限不开启，
				if(!$rbac_open){

					return $next($request);
				}
				//获取当前的 控制器名 和  方法名
				$currentC_A = $this->getCurrentController($request);
				//获取当前管理员的权限表
				$admin_info = $this->getAccess();
				//公共权限
				$common_access= config('config.COMMON_ACCESS');
				if( in_array($currentC_A['action'], $admin_info[1]) ){
					//return redirect( 'admin/404' );
					return $next($request);
				}else if(in_array($currentC_A['action'],$common_access))
				{
					//查看是否在公共权限里
					return $next($request);
				}else{
					//echo "没有权限，请联系管理员";
					return redirect( 'admin/404' );
					//return $next($request);
				}
			}
		}


		/*
		 * 获取当前进入的控制器和方法名
		 *@return array
		 */
		protected function getCurrentController( $request){
			$data = $request->route()->getAction();
			//获取当前的action
			$index_act = strpos($data['controller'],'@');
			$action = substr($data['controller'],$index_act+1);
			//获取当前的controller
			$index_con = strripos($data['controller'],'\\');
			$controller = substr($data['controller'],$index_con+1,$index_act-$index_con-1);
			$data = array(
				'controller'=>$controller,
				'action'=>$action
			);
			return $data;

		}
		/*
		 * 从session获取当前管理员的权限
		 *@return array
		 */
		protected function getAccess(){
			$data = Session::get('admin_info');
			return $data;
		}
	}
