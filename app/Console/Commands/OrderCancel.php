<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class OrderCancel extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'order:cancel';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '30分钟未付款取消订单';





	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
		parent::__construct();
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		//
		echo 'test';
		return true;
	}
}
