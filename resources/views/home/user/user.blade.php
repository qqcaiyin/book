<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />

    <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript" src="/home/js/menu.js"></script>
    <script type="text/javascript" src="/home/js/n_nav.js"></script>

    <link rel="stylesheet" type="text/css" href="/home/css/ShopShow.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/MagicZoom.css" />
    <script type="text/javascript" src="/home/js/MagicZoom.js"></script>

    <script type="text/javascript" src="/home/js/num.js">
        var jq = jQuery.noConflict();
    </script>

    <script type="text/javascript" src="/home/js/shade.js"></script>

    <title>我的账户</title>

    <style>
        .conter-right{ width: 986px; float:right;
        }
        .user-cart{float:left; width:99%; height:110px; padding: 10px; box-shadow: 5px 5px 0 #D3D4D3; background-color: #34a9ec;
        }
        .user-detail{ float:left; width:48%; height:80px; padding-right: 15px;  text-align: center; }
        .user-detail  a p { color: #fff; }
        .head-name{ float: left; width:30%; }
        .touxiang{width:55px;height:55px;border-radius: 50%;box-shadow: 0px 0px 1px #000;margin: 0 auto;display: block;;overflow: hidden;}
        .username{color:#fff;font-size: 14px;}

        .user-info{float:right;width: 60%;padding: 17px 0;}
        .user-info .left{ width:50%; float: left;text-align: left; }
        .user-info .left p{ color:#c8f0fe; line-height: 26px; }
        .user-info .left p  a { color:#fff; line-height: 26px;}
        .user-info .right{ float: left; margin-left: 15px;}
        .user-info .right p{ color:#c8f0fe; line-height: 26px;}
        .user-info .right p  a { color:#fff; line-height: 26px;}
        .user-function{float:left;width:48%;height:80px;padding-left: 15px;border-left: 1px solid #8db5cc; text-align: center; }
        .user-function ul{ display: inline-block; list-style: none; margin: 0px; padding: 20px;width:auto;  }
        .user-function ul li{ float:left; width:80px; height:80px; border-radius: 100%;  margin: 0 10px;display: block;  }
        .user-function ul li a{  disply:block; text-align: center; text-decoration: none;}
        .user-function ul li a:hover img{ transform: scale(1.4);}
        .user-function ul li a span { color:#fff;  display: block;}
        .icon{font-size:35px; color:#fff;  margin: 0 16px 0 15px; }

        .center1{  width:100%; padding: 0;  border:none;}
        .center1 .borb1 {  padding-bottom: 5px; padding-top: 2px; border-bottom:1px solid #eee;}
        .center1 .borb1 span{ font-size: 14px;  font-weight:bold;  }
        .center1 .borb1 .view-more{ float: right;  }
        .center1 .dingdan{ padding: 0; border:none;  }
        .center1 .dingdan .dd-list{ margin-bottom: 20px ; border:1px solid #eee; padding:1px;}
        .center1 .dingdan .dd-list:hover{  border:1px solid #d62728;}

        .dd-title{ background-color: #ebebeb; padding: 0 10px 0 10px;margin-left:0px;  height:38px; line-height: 38px; border:1px solid #eee; }
        .dd-title p {display: inline-block;color:#828282; margin-right: 45px;}
        .dd-detail{ display: table;  padding: 0; width:100%; background-color: #fff; }
        .dd-detail div{ margin:0 auto;  }
        .dd-detail ul{  background-color: #fff; }
        .dd-detail ul li{  float:left; disply:table-cell; vertical-align: top;  text-align: center;  display: inline-block;}
        .dd-coll{float: left;  margin: 0px; width:60%; padding:0; display: table-cell;  }
        .dd-coll .more-pro{
            padding:15px;  width:550px;
        }

        .price { display: table-cell;vertical-align: top;width:80px;text-align: center;}
        .num { display: table-cell;vertical-align: top;width:80px;text-align: center;}

        .dd-col2{  width:100px; padding: 20px 5px  ; height:100%; }
        .dd-col2.b{ font-size: 14px; margin-bottom: 8px; display: inline-block; font-weight: bolder;}
        .dd-col3{ width:90px;  padding: 15px 18px 15px 18px ; }
        .dd-col4{ float: left; width:100px; height:100%;   padding: 15px 18px 15px 18px ; border:none; }
        .dd-col4 a{display:block; width:78px; height:24px; border:1px solid #dcdcdc; text-align: center; line-height: 24px;
            margin: 8px 0 0 8px;}
        .dd-col4 a:hover{ border:1px solid #007cc3;  }
        .dd-col4 .style{ border-color:#de342f; color:#de342f;}
        .dd-col4 .style:hover{ border-color:#de342f; color:#de342f;}

        .center-bottom{ width:100%;  border:1px solid #eee;  margin-top: 20px; background-color: #fff;  }
        .center-bottom .borb{ width:100%;  padding-bottom: 5px; padding-top: 2px; border-bottom:1px solid #eee;  }
        .center-bottom .dd{ width:100%; overflow: hidden; margin: 20px 0 10px 0; padding: 0; }
        .center-bottom .dd .temprap{ }
        .dd-price{color:red;}
        .lltitle{ height:20px; overflow: hidden; display: block; text-align: left;}
        .d-list dl{ margin-right: 24px; }


    </style>
</head>
<body>

<!--Begin Header Begin-->
<div class="soubg">
    <div class="sou">
        <span class="fr">
        	<span class="fl">
                @if(!empty($memberName))
                    <a href="{{url('/user')}}">{{$memberName}}</a>&nbsp;<span style="color: #ddd;">|</span>
                    <a href="{{url('/service/out')}}" >退出</a>&nbsp;<span style="color: #ddd;">|</span>&nbsp;
                    <a href="#">我的订单</a>&nbsp;<span style="color: #ddd;">|</span>&nbsp;
                    <a href="#">会员中心</a>
                @else
                    <a href="{{url('/login')}}">登录</a>&nbsp;<span style="color: #ddd;">|</span>&nbsp;
                    <a href="Regist.html" >注册</a>&nbsp;<span style="color: #ddd;">|</span>&nbsp;
                    <a href="#">我的订单</a>&nbsp;<span style="color: #ddd;">|</span>&nbsp;
                    <a href="#">会员中心</a>
                @endif
            </span>
        </span>
    </div>
</div>
<div class="top">
    <div class="logo"><a href="Index.html"></a></div>
    <div class="search">
        <form>
            <input type="text" value="" class="s_ipt" />
            <input type="submit" value="搜索" class="s_btn" />
        </form>
        <span class="fl">
            @foreach($keywords as $keyword)
                <a href="#">{{$keyword->name}}</a>
            @endforeach
        </span>
    </div>
    <div class="i_car">
        <div class="car_t">购物车 [ <span>3</span> ]</div>
        <div class="car_bg">
            <!--Begin 购物车未登录 Begin-->
            <div class="un_login">还未登录！<a href="Login.html" style="color:#ff4e00;">马上登录</a> 查看购物车！</div>
            <!--End 购物车未登录 End-->
            <!--Begin 购物车已登录 Begin-->
            <ul class="cars">
                <li>
                    <div class="img"><a href="#"><img src="/home/images/car1.jpg" width="58" height="58" /></a></div>
                    <div class="name"><a href="#">法颂浪漫梦境50ML 香水女士持久清新淡香 送2ML小样3只</a></div>
                    <div class="price"><font color="#ff4e00">￥399</font> X1</div>
                </li>

                <li>
                    <div class="img"><a href="#"><img src="/home/images/car2.jpg" width="58" height="58" /></a></div>
                    <div class="name"><a href="#">香奈儿（Chanel）邂逅活力淡香水50ml</a></div>
                    <div class="price"><font color="#ff4e00">￥399</font> X1</div>
                </li>
            </ul>
            <div class="price_sum">共计&nbsp; <font color="#ff4e00">￥</font><span>1058</span></div>
            <div class="price_a"><a href="#">去购物车结算</a></div>
            <!--End 购物车已登录 End-->
        </div>
    </div>
</div>
<!--End Header End-->
<!--Begin Menu Begin-->
<div class="menu_bg">
    <div class="menu">
        <!--Begin 商品分类详情 Begin-->
        <div class="nav">
            <div class="nav_t">全部商品分类</div>
            <div class="leftNav none">
                <ul>
                    @foreach($categories as $category)
                        <li>
                            <div class="fj">
                                <span class="n_img"><span></span></span>
                                <span class="fl">{{$category->name}}</span>
                            </div>
                            <div class="zj">
                                <div class="zj_l">
                                    @foreach($category->son as $cs )
                                        <div class="zj_l_c">
                                            <h2><img  style=" height:40px;width:40px;" src="{{$cs->preview}}"><a href="{{url('/home/cate/'. $cs->id)}}"  >{{$cs->name}}</a></h2>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--End 商品分类详情 End-->
        <ul class="menu_r">
            @foreach($navs as $nav)
                <li><a href="{{url($nav->url)}}">{{$nav->name}}</a></li>
            @endforeach
        </ul>
        <div class="m_ad"></div>
    </div>
</div>
<!--End Menu End-->
<div class="i_bg bg_color">
    <!--Begin 用户中心 Begin -->
    <div class="m_content">
        <div class="m_left">
            <div class="left_n"><a href="{{url('/user')}}">我的账户</a></div>
            <div class="left_m">
                <div class="left_m_t "><i class="Hui-iconfont">&#xe681;</i>&nbsp;订单中心</div>
                <ul>
                    <li><a href="{{url('/myorder')}}">我的订单</a></li>
                    <li><a href="{{url('/mycomment')}}">我的评价</a></li>
                    <li><a href="{{url('/fav')}}">我的收藏</a></li>
                    <li><a href="{{url('/myservice')}}">退换货</a></li>
                </ul>
            </div>
            <div class="left_m">
                <div class="left_m_t "><i class="Hui-iconfont">&#xe60d;</i>&nbsp;账户信息</div>
                <ul>
                    <li><a href="{{url('/mymoney')}}">我的钱包</a></li>
                    <li><a href="{{url('/mypoint')}}">积分</a></li>
                    <li><a href="{{url('/myquan')}}">优惠券</a></li>
                    <li><a href="{{url('/userinfo')}}">个人信息</a></li>
                    <li><a href="{{url('/address')}}">收货地址</a></li>
                    <li><a href="#">账户安全</a></li>
                    <li><a href="#">分销</a></li>
                </ul>
            </div>
        </div>
        <div class="m_right">
            <div class="m_des" >
                <div class="user-cart" >
                    <div class="user-detail">
                        <div class="head-name">
                            <a class="touxiang" href="#">
                                <img src="{{$userInfo['avatar']}}" style="height: 60px; width:60px;">
                            </a>
                            <p class="username">您好! {{$userInfo['nickname']}}</p>
                        </div>
                        <div class="user-info">
                            <div class="left">
                                <p>会员等级：<a href="#"> 黄金</a></p>
                                <p>余额：<a href="{{url('/mymoney')}}">￥{{$userInfo['openbalance']}}</a> </p>
                            </div>
                            <div class="right">
                                <p><a href="#"></a> </p>
                                <p>积分：<a href="{{url('/mypoint')}}"> {{$userInfo['point']}}</a></p>
                            </div>
                        </div>

                    </div>
                    <div class="user-function">
                        <ul  >
                            <li class="old"><a href="{{url('/myorder?t=0')}}"> <i class="Hui-iconfont icon">&#xe628;</i><span>待付款 {{$userInfo['topay']}}</span></a></li>
                            <li class="old"><a href="{{url('/myorder?t=4')}}"> <i class="Hui-iconfont icon">&#xe634;</i><span>待发货 {{$userInfo['tosend']}}</span></a></li>
                            <li class="old"><a href="{{url('/myorder?t=5')}}"> <i class="Hui-iconfont icon">&#xe669;</i><span>待收货 {{$userInfo['torecive']}}</span></a></li>
                            <li class="old"><a href="{{url('/myorder?t=6')}}"> <i class="Hui-iconfont icon">&#xe6b3;</i><span>待评价 {{$userInfo['toeval']}}</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="center1">
                <div class="borb1" >
                    <i class="Hui-iconfont">&#xe687;&nbsp;</i><span >最近订单</span>
                    <a  class =" view-more" href="{{url('/myorder')}}">全部订单 ></a>
                </div>

                <div class="dingdan">
                    @foreach( $myOrder['orderData'] as $order)
                    <div class="dd-list">
                            <div class="dd-title">
                                <p>下单时间:&nbsp;<span> {{date('Y-m-d H:i:s',$order->add_time) }}</span></p>
                                <p>订单编号:&nbsp;<span>  {{$order->order_sn}}</span> </p>
                            </div>
                            <div class="dd-detail">
                                <ul>
                                    <li class="dd-coll" style="float:left; ">
                                        @foreach( $order['pdt'] as $pdt)
                                        <div style=" padding:15px;">
                                            <div style="  text-align: left; display:table-cell; vertical-align: top;">
                                                <a  target="_blank" href="{{url('product/' . $pdt['id'])}}"style="float: left; width:80px; height:80px;display: inline-block;">
                                                    <img src="{{url($pdt['preview'])}}"  style="width:80px; height:80px;">
                                                </a>
                                                <div style=" float:left; margin-right: 0px; width:160px; text-align: left;padding: 0 0 0 15px;">
                                                    <a target="_blank" href="{{url('product/' . $pdt['id'])}}" target="_blank">
                                                   {{$pdt['name']}}
                                                    <p class="qiangrey">
                                                        规格
                                                    </p>
                                                    </a>
                                                </div>
                                            </div>
                                            <div  class= "price"  >
                                                ￥{{$pdt['price']}}
                                            </div>
                                            <div class="num" >
                                                {{$pdt['buy_number']}}
                                            </div>
                                        </div>
                                        @endforeach
                                    </li>

                                    <li  class="dd-col2" >
                                        总额:<b >￥{{$order->order_amount}}</b>
                                        <p></p>
                                    </li>
                                    <li class="dd-col3">
                                        <p style="font-size: 14px; margin-bottom: 8px; display: block;">{{$order->status_name}}</p>
                                        <a href="{{url('/details?oid=' . $order->order_sn)}}"> 查看详情</a>
                                    </li>
                                    <li class="dd-col4"   >

                                        @if($order->status == 0)
                                            <a class="style">去支付</a>
                                            <a  href="javascript:void(0);" onclick="order_cancel(this,'{{$order->order_sn}}' ,'{{$order->id}}')">取消订单</a>
                                        @endif
                                        @if($order->status == 5 )
                                            <a href=" {{url('/details?act=sign&oid='.$order->order_sn)}} " style="border:1px solid #007cc3;" style="margin: 5px  40px; " >签收</a>
                                        @endif
                                        @if($order->status == 6)<a href="{{url('/comment?oid=' .$order->order_sn )}}"style="border:1px solid #007cc3;">评论</a>@endif
                                        @if($order->status >= 1)<a   href="{{url('/service/cart? act=readd_cart&oid=' . $order->id)}}">再次购买</a>@endif
                                    </li>
                                </ul>
                            </div>
                    </div>
                    @endforeach
                </div>

                <div class="center-bottom"  id="slide-change">
                    <div class="borb1" >
                        <i class="Hui-iconfont">&#xe715;&nbsp;</i><span >最近浏览</span>
                        <a  class =" view-more next" href="javascript:;">换一组>&nbsp;&nbsp;</a>
                    </div>
                    <div class="dd">
                        <div class="temprap" style="overflow: hidden; position: relative;width:950px;">
                            <div class="d-list" style="width:2716px; position: relative;overflow: hidden; padding: 0px; margin: 0px; left:-220px; ">
                                @foreach($visit_log as $v)
                                <dl class="clone" style="float:left; width:110px;">
                                    <dt>
                                        <a  target="_blank" href="{{url('/product/' . $v['id'])}}" > <img src="{{$v['preview']}}" style=" width:110px;height:120px;" >  </a>
                                    </dt>
                                    <dd>
                                        <a   target="_blank"   href="{{url('/product/' . $v['id'])}}">
                                            <span class="lltitle">{{$v['name']}}</span>
                                            <span class="price">￥{{$v['price']}}</span>
                                        </a>
                                    </dd>
                                </dl>
                               @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--End 用户中心 End-->
    <!--Begin Footer Begin -->
    <div class="b_btm_bg b_btm_c">
        <div class="b_btm">
            <table border="0" style="width:210px; height:62px; float:left; margin-left:75px; margin-top:30px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="72"><img src="/images/bz.png" width="67" height="62" /></td>
                    <td><h2>正品保障</h2></td>
                </tr>
            </table>
            <table border="0" style="width:210px; height:62px; float:left; margin-left:75px; margin-top:30px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="72"><img src="/images/peisong.png" width="67" height="62" /></td>
                    <td><h2>满38包邮</h2></td>
                </tr>
            </table>
            <table border="0" style="width:210px; height:62px; float:left; margin-left:75px; margin-top:30px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="72"><img src="/images/sh.png" width="67" height="62" /></td>
                    <td><h2>售后无忧</h2></td>
                </tr>
            </table>
            <table border="0" style="width:210px; height:62px; float:left; margin-left:75px; margin-top:30px;" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="72"><img src="/images/bb.png" width="62" height="62" /></td>
                    <td><h2>帮助中心</h2></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="b_nav">
        <dl>
            <dt><a href="#">新手上路</a></dt>
            <dd><a href="#">售后流程</a></dd>
            <dd><a href="#">购物流程</a></dd>
            <dd><a href="#">订购方式</a></dd>
            <dd><a href="#">隐私声明</a></dd>
            <dd><a href="#">推荐分享说明</a></dd>
        </dl>
        <dl>
            <dt><a href="#">配送与支付</a></dt>
            <dd><a href="#">货到付款区域</a></dd>
            <dd><a href="#">配送支付查询</a></dd>
            <dd><a href="#">支付方式说明</a></dd>
        </dl>
        <dl>
            <dt><a href="#">会员中心</a></dt>
            <dd><a href="#">资金管理</a></dd>
            <dd><a href="#">我的收藏</a></dd>
            <dd><a href="#">我的订单</a></dd>
        </dl>
        <dl>
            <dt><a href="#">服务保证</a></dt>
            <dd><a href="#">退换货原则</a></dd>
            <dd><a href="#">售后服务保证</a></dd>
            <dd><a href="#">产品质量保证</a></dd>
        </dl>
        <dl>
            <dt><a href="#">联系我们</a></dt>
            <dd><a href="#">网站故障报告</a></dd>
            <dd><a href="#">购物咨询</a></dd>
            <dd><a href="#">投诉与建议</a></dd>
        </dl>
        <div class="b_tel_bg">
            <a href="#" class="b_sh1">新浪微博</a>
            <a href="#" class="b_sh2">腾讯微博</a>
            <p>
                服务热线：<br />
                <span>400-123-4567</span>
            </p>
        </div>
        <div class="b_er">
            <div class="b_er_c"><img src="/home/images/er.gif" width="118" height="118" /></div>
            <img src="/home/images/ss.png" />
        </div>
    </div>
    <!--Begin Footer Begin-->
    <div class="btmbg">
        <div class="btm ">
            <a href="/" target="_blank">首页</a>| <a href="/n-about.html" target="_blank">关于我们</a>
            | <a href="/n-help.html" target="_blank">联系我们</a>
            | <a href="/n-help.html" target="_blank">帮助中心</a>
        </div>
        <div class="btm" >
            <p>Copyright © 2015-2018  All Rights Reserved.  </p>
        </div>
    </div>
    <!--End Footer End -->>
</div>

<!--bengin 轮播 bengin -->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script src="/home/js/jquery.SuperSlide.2.1.1.js" type="text/javascript" ></script>
<!--End 轮播 End -->
<script>


    $("#slide-change").slide({ mainCell:".d-list", effect:"leftLoop",autoPage:true,scroll:7,vis:7});



    function  order_cancel(obj,sn ,oid){
        layer.confirm('确认要取消订单吗？',function (index) {
            var url = '/service/order'
            $.get(url,{ act:'order_cancel' , order_sn:sn ,oid:oid},function(data){
                console.log(data);
                if(data.status == 0){
                    layer.msg(data.message, {icon:1, time:2000});
                    location.replace(location.href);
                }
                console.log(data);

            },'json');

        });
    }

</script>

</body>




</html>
