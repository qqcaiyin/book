<?php


namespace  App\Http\Repository;

use App\Entity\Cart;
use App\Entity\Myfav;
use App\Entity\Order;
use App\Entity\Pdt_id_attr;
use App\Entity\Pdt_sku;
use App\Entity\Product;

use DB;
class OrderRepository{

	protected  $order;

	public function __construct( Order $order){
		$this->order = $order;
	}







}


