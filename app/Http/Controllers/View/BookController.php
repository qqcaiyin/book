<?php

namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\Pdt_content;
use App\Entity\Pdt_images;
use App\Entity\Product;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class BookController extends Controller
{
	public function toCategory(){

		$categorys = Category::where('parent_id','')->get();
		Log::info('进入书库');
		return view('category')->with('categorys',$categorys);
	}
	public function toProduct($category_id){

		$products = Product::where('category_id',$category_id)->get();
		return view('product')->with('products',$products);
	}

	public function toPdtContent(Request $request, $product_id){

		$product = Product::find($product_id);
		$pdt_content = Pdt_content::where('product_id',$product_id)->first();
		$pdt_images = Pdt_images::where('product_id',$product_id)->get();

		$bk_cart = $request->cookie('bk_cart');
		$bk_cart_arr = ($bk_cart != null ?  explode(',',$bk_cart) : array());

		$count = 0;
		foreach ($bk_cart_arr  as $value){
			$index = strpos($value,':');
			if(substr($value,0 , $index) == $product_id){
				$count = ((int)substr($value,$index+1));
				break;
			}
		}

		return view('pdt_content')->with('product',$product)
			                            ->with('pdt_content',$pdt_content)
										->with('pdt_images',$pdt_images)
										->with('count',$count);
	}
}
