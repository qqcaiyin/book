<?php


namespace  App\Http\Repository;

use App\Entity\Comment;
use App\Entity\Comment_msg;
use App\Entity\Pdt_id_attr;
use App\Entity\Product;

use DB;
class CommentRepository{

	protected  $comment;

	public function __construct( Comment $comment){
		$this->comment = $comment;
	}

	//获取商品评论
	public function getCommentList($goodId ,  $page= 1 , $limit =10){

		$comment= Comment::where('pdt_id',$goodId)
						  ->where('is_show',1)
						  ->leftjoin('member as m','m.id','=','member_id')
			              ->select('comment.id','star_num','content','is_anony','spec' ,'time','member_name as user_name','m.avatar as user_avatar ')
			              ->offset(($page-1)*$limit)->limit($limit)
			              ->get()->toarray();

		if(count($comment)){
			foreach ($comment as $key => &$value){
				//获取子回复
				$value['children'] = $this->getChildrenComment($value['id']);
				//获取规格
				if($value['spec']){
					$value['spec'] = Pdt_id_attr::getSpecName($value['spec']);
				}
			}

		}

		return $comment;
	}


	//获取子评论
	public function  getChildrenComment( $commentId= 0, $page = 1, $limit = 10){

		return Comment_msg::where('pid',$commentId)->where('is_show',1)
					->select( 'reply_name','uname' ,'content','add_time'  )
					->offset(($page-1)*$limit)->limit($limit)->get()->toArray();

	}



}


