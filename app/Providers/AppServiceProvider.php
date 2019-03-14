<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator ;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		// 手机号码格式验证
		Validator::extend('telphone', function ($attribute, $value, $parameters) {
			return preg_match('/^1[34578][0-9]{9}$/', $value);
		});

		//密码格式验证 密码必须由字母和数字组成
		Validator::extend('zzregex', function ($attribute, $value, $parameters) {
			return preg_match('/([0-9]+[a-zA-Z]+|[a-zA-Z]+[0-9]+)[0-9a-zA-Z]*/', $value);
		});
	}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
