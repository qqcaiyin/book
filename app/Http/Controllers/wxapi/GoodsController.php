<?php

namespace App\Http\Controllers\Wxapi;

use App\Entity\Category;
use App\Entity\Myfav;
use App\Http\Repository\CartRepository;
use App\Http\Repository\CommentRepository;
use App\Http\Repository\GoodsRepository;
use App\Http\Requests\AddrRequest;




use DB;
use Illuminate\Http\Request;

class GoodsController extends ApiController
{

	protected $goodsRepository;
	protected $commentRepository;
	protected $cartRepository;

	public function __construct(GoodsRepository   $goodsRepository  ,
								CommentRepository $commentRepository ,
								CartRepository $cartRepository){

		$this->goodsRepository = $goodsRepository;
		$this->commentRepository = $commentRepository;
		$this->cartRepository = $cartRepository;
	}

	/**
	 * 获取商品列表信息
	 * @return
	 */
	public function getGoodsList( Request $request){

		$data = $this->requestCheck($request->all());

		//原生拼接语句   ，laravel  5.1
		$where = 1;
		if($data['pid']){
			$cateId = Category::getAllChildrenCategoryByParentId($data['pid']);
			if($cateId){
				$where .=  '  and  category_id in ('.implode(',', $cateId).')';
			}else{
				return $this->failed('类别ID异常');
			}
		}
		if(isset($data['keyword']) && $data['keyword']){
			//搜索关键字
			$word = $data['keyword'];
			$wordlist=str_replace("+",",",$word);
			$wordlist=str_replace(" ",",",$wordlist);
			$wordlistx=explode(',',$wordlist);
			$where .=" and ( ";
			$keyworksqland='';
			for ($k=0;$k<count($wordlistx);$k++){
				if ($k>0  ){
					$keyworksqland=" and ";
				}
				if ( $wordlistx[$k] !='' ){
					$where .=$keyworksqland."  name like '%".addslashes($wordlistx[$k])."%'";
				}
			}
			$where .=" ) ";
		}
		if(isset($data['isNew']) && $data['isNew']){
			//新品
			$where .=  ' and is_new=1';
		}
		if(isset($data['isHot']) && $data['isHot']){
			//热销商品
			$where .=  '  order by  salenum  desc  ';
		}
		if(isset($data['orderByPrice']) && $data['orderByPrice']){
			//根据价格排序
			$where .=  '    order by  price  '.   $data['orderByPrice']  ;
		}

		$goodsList = $this->goodsRepository->getGoodsList($where,$data['page']);
		return $this->respondWithSuccess($goodsList);
	}


	/**
	 * 获取商品详情
	 * @return
	 */
	public function getGoodsDetails( Request $request){

		$data = $this->requestCheck($request->all());

		$goodsInfo =$this->goodsRepository->getGoodsDetails($data['id']);
		$comment = $this->commentRepository->getCommentList($data['id']);
		$userHasFav = $this->goodsRepository->userFavStatus($data['id']);
		$productSku = $this->goodsRepository->getProductSku($data['id']);
		$goodsSpec = $this->goodsRepository->getGoodsSpec($data['id']);
		$cartGoodsNum = $this->cartRepository->getCartGoodsNum();
		$outData = [
			'info' => $goodsInfo,      		//商品信息
			'goodsSpec' => $goodsSpec,      //规格参数
			'productSku' =>$productSku,  	//商品的sku
			'comment' => $comment,			//商品评论
			'userHasFav' => $userHasFav,	//是否收藏
			'cartGoodsNum' =>$cartGoodsNum  //购物车产品数量
		];

		return $this->respondWithSuccess($outData);

	}

	/**
	 * 收藏商品
	 * @return
	 */
	public function addToCollection(Request $request){
		$data = $this->requestCheck($request->all());

		if(!$data['fav']){
			$res = Myfav::where('member_id',70)->where('product_id',$data['id'])->delete();
		}else if($data['fav']){
			$isHas = Myfav::where('member_id',70)->where('product_id',$data['id'])->first();
			if(!$isHas){
				$res = Myfav::insertGetId(['member_id' =>70, 'product_id'=>$data['id'], 'time' =>time()
				]);
			}
		}

		if($res){
			return $this->success('ok');
		}
		return $this->failed('error');

	}




}
