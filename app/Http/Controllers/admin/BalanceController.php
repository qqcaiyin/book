<?php

namespace App\Http\Controllers\Admin;


use App\Entity\Balance_log;
use App\Entity\Category;
use App\Entity\Member;
use App\Entity\Member_grade;
use App\Models\M3Result;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class BalanceController extends Controller
{

////////////////视图界面/////////////////
	/**
	 * 余额管理列表试图
	 * @return[type][description]
	 */
	public function toBalanceList()
	{

		$balance_logs = DB::table('balance_log')
			->join('member', 'balance_log.member_id', '=', 'member.id')
			->select('balance_log.*', 'member.nickname')
			->orderBy('balance_log.id', 'des')
			->paginate(15);


		return view('admin/member/balance_list', compact('balance_logs'));
	}

	/**
	 * 余额管理搜索结果
	 * @return[type][description]
	 */
	public function logSearch(Request $request){

		$data = $request->all();
		//搜索的起，止时间转换为时间戳
		$nickname = trim($data['nickname']);
		$starttime = strtotime(trim($data['starttime']));
		$endtime = trim($data['endtime'])=='' ? time():( strtotime(trim($data['endtime']))+24*60*60);
		//两表联查，
		$balance_logs = DB::table('balance_log')
			->join('member', 'balance_log.member_id', '=', 'member.id')
			->select('balance_log.*', 'member.nickname')
			->where('member.nickname',$nickname)
			->whereBetween('balance_log.time',[$starttime,$endtime])
			->orderBy('balance_log.id', 'desc')
			->paginate(2);
		//
		//使用appends把参数配置上，
		//$request->input取得是url参数的值，把参数拼进去。再点击下一页的时候就链接跳转进入控制器处理，就可以获取到查询条件了。
		$appendData = $balance_logs->appends(array(
			'nickname' => $nickname,
			'starttime' => $data['starttime'] ,
			'endtime' => $data['endtime'],
		));
		//用于回显搜索条件
		$balance_logs->ser = array(
			'nickname' => $nickname,
			'starttime' => $data['starttime'] ,
			'endtime' => $data['endtime'],
		);
		$balance_logs->ser_count = count($balance_logs);

		return view('admin/member/balance_list', compact('balance_logs'));

	}

}
