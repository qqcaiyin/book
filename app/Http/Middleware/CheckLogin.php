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
			$http_refer = $_SERVER['HTTP_REFERER'];

			//Session::put('member','');//清除登陆信息
			$member = $request->session()->get('member','');
			if($member == ''){
				return redirect('/login?return_url' .urlencode($http_refer) );
				//return redirect('/login');
			}
			return $next($request);
		}
	}
