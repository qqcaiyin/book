<?php

namespace App\Http\Controllers\Service;

use App\Entity\Category;
use App\Models\M3Result;
use App\Tool\UUID;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

	/**
	 * 多图上传  插件  webuploader
	 *
	 * @return json  返回上传图片的存储地址
	 */
	public function webUploader(){

		return view('admin/webuploader');
	}

	public function ser(){

		$m3_result = new M3Result;

// Support CORS
// header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
			exit; // finish preflight CORS requests here
		}

		if ( !empty($_REQUEST[ 'debug' ]) ) {
			$random = rand(0, intval($_REQUEST[ 'debug' ]) );
			if ( $random === 0 ) {
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		}

// 5 minutes execution time
		@set_time_limit(5 * 60);
// Uncomment this one to fake upload time
// usleep(5000);

// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
		$targetDir = 'upload_tmp';
		$uploadDir = 'upload';

		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir  类似于中转站
		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}
//设置好保存路径
		$public_dir = sprintf('/upload/images/%s/',date('Ymd'));
		$uploadDir =  public_path().$public_dir;
// Create target dir 创建目的文件夹
		if (!file_exists($uploadDir)) {
			@mkdir($uploadDir,0777,true);
		}

// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		//文件扩展名
		$arr_ext = explode('.',$_FILES['file']['name']);
		$file_ext = count($arr_ext) >1 &&strlen(end($arr_ext)) ? end($arr_ext) : "unknow";
		//合成照片
		$upload_filename = UUID::create();
		$filename = $upload_filename . '.' . $file_ext;

//DIRECTORY_SEPARATOR   分隔符

		$filePath = $targetDir . $filename;
		$uploadPath = $uploadDir . $filename;
		$url = $public_dir.$filename;

// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Remove old temp files
		if ($cleanupTargetDir) {
			if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
			}

			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

				// If temp file is current file proceed to the next
				if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
					continue;
				}

				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		}

// Open temp file
		if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

		$index = 0;
		$done = true;
		for( $index = 0; $index < $chunks; $index++ ) {
			if ( !file_exists("{$filePath}_{$index}.part") ) {
				$done = false;
				break;
			}
		}
		if ( $done ) {
			if (!$out = @fopen($uploadPath, "wb")) {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}
//进行排它型锁定
			if ( flock($out, LOCK_EX) ) {
				for( $index = 0; $index < $chunks; $index++ ) {
					if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
						break;
					}
//写入
					while ($buff = fread($in, 4096)) {
						fwrite($out, $buff);
					}

					@fclose($in);
					@unlink("{$filePath}_{$index}.part");//删除文件
				}

				flock($out, LOCK_UN);
			}
			@fclose($out);
		}

// Return Success JSON-RPC response
		$m3_result->src=$url;
		return $m3_result->toJson();


}

	//测试代码接收数据
	public function getImages(Request $request){
		$all =$request->all();
		dd($all);
	}

	/**
	 * 单图多图上传
	 *
	 * @return json  返回上传图片的存储地址
	 */
	public function uploadFile( Request $request,$type){

		$width = $request->input('width','');
		$height = $request->input('height','');

		$m3_result = new M3Result;
		$m3_result->status = 0;
		$m3_result->message = "更新成功";

		if($_FILES['file']['error'] > 0){
			$m3_result->status = 2;
			$m3_result->message = "未知错误, 错误码: " . $_FILES["file"]["error"];
			return $m3_result->toJson();
		}

		$file_size = $_FILES['file']['size'];
		if($file_size > 1024*1024){
			$m3_result->status = 2;
			$m3_result->message = "请注意图片上传大小不能超过1M";
			return $m3_result->toJson();
		}
		//设置好上传图片存储路径
		$public_dir = sprintf('/upload/%s/%s/',$type,date('Ymd'));
		$upload_dir = public_path().$public_dir;
		if(!file_exists($upload_dir)){
			mkdir($upload_dir,0777,true);
		}

		//获取文件扩展名
		$arr_ext = explode('.',$_FILES['file']['name']);
		$file_ext = count($arr_ext) >1 &&strlen(end($arr_ext)) ? end($arr_ext) : "unknow";
		//合成照片
		$upload_filename = UUID::create();
		$upload_file_path = $upload_dir . $upload_filename . '.' . $file_ext;
		if(strlen($width)>0){
			$public_uri = $public_dir . $upload_filename . '.' .$file_ext;
			$m3_result->status = 0;
			$m3_result->message = "上传成功";
			$m3_result->uri = $public_uri;
		}else{
			if(move_uploaded_file($_FILES['file']['tmp_name'],$upload_file_path)){
				$public_uri = $public_dir . $upload_filename .'.' . $file_ext;
				$m3_result->status = 0;
				$m3_result->message = "上传成功";
				$m3_result->uri = $public_uri;
			}else{
				$m3_result->status = 1;
				$m3_result->message = "上传失败，权限不足";
			}
		}
		return $m3_result->toJson();
	}

	public function imagesDel(Request $request){

		$m3_result = new M3Result;

		$filePath = $request->input('src');

		$res = file_exists('.' . $filePath);
		if($res){
			$resDel = unlink('.' . $filePath);
			if($resDel){
				$m3_result->status = 0;
				$m3_result->message = "删除成功";
			}else{
				$m3_result->status = 10;
				$m3_result->message = "删除失败";
			}
		}

		return $m3_result->toJson();

	}

}
