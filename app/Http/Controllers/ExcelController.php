<?php

namespace App\Http\Controllers;

use App\Entity\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;

class ExcelController extends Controller
{
    /**
     * 导出数据库的表到excel.
     *
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
		$cellData = Category::select('id','name', 'category_no','parent_id' )->get();
		Excel::create('图书分类统计表',function($excel) use ($cellData){
			$excel->sheet('分类信息', function($sheet) use ($cellData){
				$sheet->fromModel($cellData)
				->freezeFirstRow();//冻结第一行
			});

		})->store('xls',storage_path('excel/exports'))->export('xls');
		//})->export('xls');
    }
	/**
	 * 导入excel到数据库
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function import(){
		$filePath ='storage/excel/exports/图书分类统计表'. '.xls';
		Excel::load($filePath,function($reader){
			//获取excel第几张表
			$reader = $reader->getSheet(0);
			$data = $reader->toArray();
			 array_shift($data);//删除第一个数组，
			foreach ($data as $d){
				$category = new Category;
				$category->name = $d[1];
				$category->category_no = $d[2];
				$category->parent_id = $d[3];
				$category->save();
			}
			//dd($data);
		});
	}

}
