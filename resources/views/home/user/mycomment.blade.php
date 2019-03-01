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
    <script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
    <title>我的账户</title>

    <style>
        .center1{  width:100%; padding: 0;  border:none;background-color: #fff;  }


        .center1 .dingdan{ margin-top: 20px;  }
        .center1 .dingdan .dd-list{ margin-top: 0px ;  }

        .dd-title{  display: table;   width:100%; background-color: #eee; height:34px; line-height: 34px;}

        .dd-title ul li{
            display:table-cell;float:left;height:34px;line-height: 34px; text-align: center;
        }
        .dd-title .td1 { width:15%;text-align: center;}
        .dd-title .td2 { width:40%;text-align: left;}
        .dd-title .td3 { width:35%;text-align: center;}
        .dd-title .td4 { width:10%;text-align: center;}
        .dd-title p {display: inline-block;color:#828282; margin-right: 45px;}


        .dd-detail{ display: table;  padding: 0; width:100%; background-color: #fff;text-align: center;  }
        .dd-detail div{ margin:0 auto;  }
        .dd-detail ul{  background-color: #fff; }
        .dd-detail ul li{  float:left; disply:table-cell; vertical-align: middle; border-bottom:1px dashed #ddd; text-align: center;  display: inline-block;}
        .dd-coll{ display: table; width:100%; border-bottom: 1px solid #eee;   }
        .dd-coll .more-pro{  width:10%; display: table-cell; text-align: left; vertical-align: top; float:left;  }

        .dd-coll .price { display: table-cell;width:40%;text-align: center; float:left;vertical-align: middle; }
        .dd-coll .num { display: table-cell;width:40%;text-align: center;float:left; vertical-align: middle;}
        .dd-coll .total { display: table-cell;width:10%;text-align: center;float:left; vertical-align: middle;}

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
            <div class="left_n">我的账户</div>
            <div class="left_m">
                <div class="left_m_t "><i class="Hui-iconfont">&#xe681;</i>&nbsp;订单中心</div>
                <ul>
                    <li><a href="Member_Order.html">我的订单</a></li>
                    <li><a href="Member_Address.html">我的评价</a></li>
                    <li><a href="#">我的收藏</a></li>
                    <li><a href="#">退换货</a></li>
                </ul>
            </div>
            <div class="left_m">
                <div class="left_m_t "><i class="Hui-iconfont">&#xe60d;</i>&nbsp;账户信息</div>
                <ul>
                    <li><a href="Member_User.html">我的钱包</a></li>
                    <li><a href="Member_Collect.html">积分</a></li>
                    <li><a href="Member_Msg.html">优惠券</a></li>
                    <li><a href="Member_Links.html">个人信息</a></li>
                    <li><a href="#">收货地址</a></li>
                    <li><a href="#">账户安全</a></li>
                    <li><a href="#">分销</a></li>
                </ul>
            </div>
        </div>
        <div class="m_right">

            <div class="center1">
                <div class="borb" >
                    <div class= "lside">
                        <ul>
                            <li><a  class="cur"  href="#">全部评论</a> </li>

                        </ul>
                    </div>
                </div>
                <!--评论订单列表 -start--->
                    <div class="dingdan" style="margin-top: 0px;" >
                        <div class="dd-list">
                            <div class="dd-title">
                                <ul >
                                    <li class="td1">订单号</li>
                                    <li class="td2">商品名称</li>
                                    <li class="td3">评论内容</li>
                                    <li class="td4">操作</li>
                                </ul>
                            </div>
                            <div class="dd-detail">
                                <ul>
                                    @foreach( $comments['orderData'] as $pdt)
                                        <li class="dd-coll" style="float:left; ">
                                            <div >
                                                <div class="more-pro" style="text-align: center; ">
                                                   {{$pdt['order_sn']}}
                                                </div>
                                                <div  class= "price" style="text-align: center; "  >
                                                    <div style=" float:left; margin-right: 0px; text-align: left;padding: 0 0 0 15px;">
                                                        @foreach($pdt['pdt'] as $v)
                                                            <p>
                                                                {{$v['name']}}
                                                            </p>
                                                         @endforeach
                                                    </div>
                                                </div>
                                                <div class="num"  >
                                                    @foreach($pdt['pdt'] as $v)
                                                        <p>&nbsp;
                                                        @if($v['star_num']!=0)

                                                              <span style="color: #007cc3; font-weight: bolder;">[{{$v['star_num']}} 星]</span>  {{$v['comment']}}
                                                        @endif
                                                        </p>
                                                    @endforeach
                                                </div>
                                                <div class="total" >
                                                  <a  style="color: #007cc3" href="{{url('/details?oid=' . $pdt['order_sn'])}}">订单详情   </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                <!--评论订单列表 -end--->
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
<script src="/home/js/jquery.SuperSlide.2.1.1.js" type="text/javascript" ></script>
<!--End 轮播 End -->
<script>


    $("#slide-change").slide({ mainCell:".d-list", effect:"leftLoop",autoPage:true,scroll:7,vis:7});

</script>

</body>




</html>
