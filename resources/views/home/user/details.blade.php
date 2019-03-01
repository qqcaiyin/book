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

         .pwlp{ background-color: #fff; border-top:1px solid #eee;border-bottom:1px solid #eee; width:100%; overflow: hidden; display: table ; float: left; }
        .pwlp .tdl{ float:left; width:20%;     padding-top:100px;   text-align: center;}
        .pwlp .tdr{float:right;  width:75%;  height:300px;  border-left:1px solid #ddd; }

        .infor-buy-view{ float:left; background-color: #fff; border-top:1px solid #eee;border-bottom:1px solid #eee; width:100%; margin: 2% 0; overflow: hidden; display: table ;  }
        .infor-buy-view  .addr{ float: left; width:35%;  display: table-cell; padding: 5px;  }
        .infor-buy-view  .pay{ float: left; width:25%;  display: table-cell;border-left: 1px dashed #ddd;border-right: 1px dashed #ddd;padding: 5px; }
        .infor-buy-view  .wuliu{ float: left;width:35% ;  display: table-cell; padding: 5px;}

        .detail-box{height: 100%;   }
        .detail-box ul li span{ display: table-cell; width:80px;}
        .detail-box ul li p{ display: table-cell; }

        .center1 .dingdan{ margin-top: 20px;  }
        .center1 .dingdan .dd-list{ margin-top: 20px ;  }

        .dd-title{  display: table;   width:100%; background-color: #eee; height:34px; line-height: 34px;}

        .dd-title ul li{
            display:table-cell;float:left;height:34px;line-height: 34px; text-align: center;
        }
        .dd-title .td1 { width:50%;text-align: center;}
        .dd-title .td2 { width:20%;text-align: center;}
        .dd-title .td3 { width:10%;text-align: center;}
        .dd-title .td4 { width:20%;text-align: center;}
        .dd-title p {display: inline-block;color:#828282; margin-right: 45px;}


        .dd-detail{ display: table;  padding: 0; width:100%; background-color: #fff; }
        .dd-detail div{ margin:0 auto;  }
        .dd-detail ul{  background-color: #fff; }
        .dd-detail ul li{  float:left; disply:table-cell; vertical-align: top; border-right: 1px solid  #eee; text-align: center;  display: inline-block;}
        .dd-coll{ display: table; width:100%; border-bottom: 1px solid #eee;   }
        .dd-coll .more-pro{  width:50%; display: table-cell; text-align: left; vertical-align: top; float:left;  }

        .dd-coll .price { display: table-cell;width:20%;text-align: center; float:left;vertical-align: middle; }
        .dd-coll .num { display: table-cell;width:10%;text-align: center;float:left; vertical-align: middle;}
        .dd-coll .total { display: table-cell;width:20%;text-align: center;float:left; vertical-align: middle;}


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
                    <a href="{{url('/register')}}" >注册</a>&nbsp;<span style="color: #ddd;">|</span>&nbsp;
                    <a href="#">我的订单</a>&nbsp;<span style="color: #ddd;">|</span>&nbsp;
                    <a href="#">会员中心</a>
                @endif
            </span>
        </span>
    </div>
</div>
<!--End Header End-->
<!--End Menu End-->
<div class="i_bg bg_color">
    <!--Begin 用户中心 Begin -->
    <div class="m_content">
        <div class="m_left">
            <div class="left_n">我的账户</div>
            <div class="left_m">
                <div class="left_m_t"><i class="Hui-iconfont">&#xe681;</i>&nbsp;订单中心</div>
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
                <div class="wuliu-detail">
                    <p style="text-align: left; padding-top: 20px ; padding-left: 30px;">
                        订单号：
                        <span style="color:#e35d5a; margin-right: 30px;">
                            {{$orderDetail['order_sn']}}
                        </span>
                        {{$orderDetail['status_desc']}}
                    </p>
                    <div class = "wuliu-detail-dd ">
                        <ul>
                            <li>
                                <div >
                                    <i class="icon-wuliu order-success"></i>
                                </div>
                                <p>提交订单</p>
                                <p>{{date('Y-m-d',$orderDetail['add_time'])}}</p>
                            </li>
                            <li class=" ll  next-line{{$orderDetail['status_shipping'][1]}}   ">
                            </li>
                            <li>
                                <div >
                                    <i class="icon-wuliu order-send{{$orderDetail['status_shipping'][2]}}  "></i>
                                </div>
                                <p>正在发货</p>
                                @if($orderDetail['status_shipping'][2] == 1)
                                <p>{{date('Y-m-d',$orderDetail['shipping_time'])}}</p>
                                @endif
                            </li>
                            <li class=" ll  next-line{{$orderDetail['status_shipping'][3]}} ">
                            <li>
                                <div >
                                    <i class="icon-wuliu order-qs{{$orderDetail['status_shipping'][4]}}"></i>
                                </div>
                                <p>签收</p>
                                @if($orderDetail['status_shipping'][4] == 1)
                                    <p>{{date('Y-m-d',$orderDetail['confirm_time'])}}</p>
                                @endif
                            </li>
                            <li class=" ll  next-line{{$orderDetail['status_shipping'][5]}}  ">
                            <li>
                                <div>
                                    <i class="icon-wuliu order-end{{$orderDetail['status_shipping'][6]}} "></i>
                                </div>
                                <p>完成</p>
                                <p>{{date('Y-m-d',$orderDetail['complete_time'])}}</p>
                            </li>
                        </ul>
                    </div>
                </div>



                <div  class="pwlp">
                    <div class="tdl">
                        <div >
                            订单状态: <span style="font-weight: bolder; color:#007cc3;">{{$orderDetail['status_name']}}</span>

                            @if($orderDetail['next_stepdesc'] == 'topay' )
                            <a class="topay" style="margin: 5px  40px; " >去付款</a>
                            @endif
                            @if($orderDetail['next_stepdesc'] == 'tosign' )
                                <a href=" {{url('/details?act=sign&oid='.$orderDetail['order_sn'])}} " class="topay" style="margin: 5px  40px; " >签收</a>
                            @endif
                            @if($orderDetail['next_stepdesc'] == 'tomsg' )
                                <a class="topay"  style="margin: 5px  40px;" href=" {{url('/comment?oid='.$orderDetail['order_sn'])}} " >去评论</a>
                            @endif

                        </div>
                    </div>
                    <div class="tdr" >

                        <div style=" float:left;border-bottom:1px solid #eee; width:100%; height:30px;">
                           <p style="color:#007cc3;">{{$orderDetail['shipping_name']}}：{{$orderDetail['shipping_sn']}}</p>
                        </div>
                        <div style="margin-top: 20px;margin-left: 30px; border:1px solid #fff;   ;min-height:200px;max-height:200px;overflow-y: auto;	">
                            @if($shipInfo['message'] == 'ok')
                                @foreach($shipInfo['data'] as $key => $v)
                                    @if($key == 0)
                                        <p style="font-size: 16px; color:#007cc3;font-weight: bolder;">{{ $v['time']  }} :{{$v['context']}}</p>
                                    @else
                                        <p>{{ $v['time']  }} :<span style="margin-left: 20px;">{{$v['context']}}</span></p>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                    </div>
                </div>

                <div class="infor-buy-view">
                    <div class="addr">
                        <h4>收货人信息</h4>
                        <div class="detail-box">
                            <ul>
                                <li>
                                    <span> 收货人：</span>
                                    <p >{{$orderDetail['consignee']}}</p>
                                </li>
                                <li>
                                    <span>收货地址：</span>
                                    <p >{{$orderDetail['province']}}{{$orderDetail['city']}}{{$orderDetail['province']}}{{$orderDetail['address']}} &nbsp;{{$orderDetail['zipcode']}}</p>
                                </li>
                                <li>
                                    <span> 手机号码：</span>
                                    <p >{{$orderDetail['moble']}}</p>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="pay">
                        <h4>付款信息</h4>
                        <div class="detail-box">
                            <ul>
                                <li>
                                    <span> 付款方式：</span>
                                    <p >支付宝 </p>
                                </li>
                                <li>
                                    <span> 商品总额：</span>
                                    <p >{{$orderDetail['products_amount']}}</p>
                                </li>
                                <li>
                                    <span> 运费：</span>
                                    <p >{{$orderDetail['shipping_fee']}}</p>
                                </li>
                                <li>
                                    <span> 应付总额：</span>
                                    <p >{{$orderDetail['order_amount']}}</p>
                                </li>
                                <li>
                                    <span> 未付金额：</span>
                                    <p >{{$orderDetail['order_amount'] - $orderDetail['money_paid'] }}</p>
                                </li>
                                <li>
                                    <span> 余额支付：</span>
                                    <p >{{$orderDetail['balance_amount']}}</p>
                                </li>
                                <li>
                                    <span> 积分支付：</span>
                                    <p >{{$orderDetail['point_amount']}}</p>
                                </li>
                                <li>
                                    <span> 优惠券：</span>
                                    <p >{{$orderDetail['bonus']}}</p>
                                </li>


                            </ul>

                        </div>
                    </div>
                    <div class="wuliu">
                        <h4>物流信息</h4>
                        <div class="detail-box">
                            <ul>
                                <li>
                                    <span> 配送方式：</span>
                                    <p ></p>
                                </li>
                                <li>
                                    <span>运费：</span>
                                    <p ></p>
                                </li>
                                <li>
                                    <span> 发货时间：</span>
                                    <p ></p>
                                </li>
                            </ul>
                        </div>
                        <h4 style=" margin-top: 20px; border-top:1px dashed #ddd; width:100%;">发票信息</h4>
                        <div class="detail-box" >
                            不开发票
                        </div>
                    </div>
                </div>

                <div class="dingdan" >
                        <div class="dd-list">
                            <div class="dd-title">
                             <ul >
                                 <li class="td1">商品</li>
                                 <li class="td2">单价（元）</li>
                                 <li class="td3">数量</li>
                                 <li class="td4">金额</li>
                             </ul>
                            </div>
                            <div class="dd-detail">
                                <ul>
                                    @foreach( $orderDetail['pdt'] as $pdt)
                                    <li class="dd-coll" style="float:left; ">
                                            <div >
                                                <div class="more-pro" style=" ">
                                                    <a   href="{{url('product/' . $pdt['id'])}} "style="float: left; width:60px; height:60px;display: inline-block;">
                                                        <img src="{{url($pdt['preview'])}}"  style="width:50px; height:50px; ">
                                                    </a>
                                                    <div style=" float:left; margin-right: 0px; text-align: left;padding: 0 0 0 15px;">
                                                        <a href="{{url('product/' . $pdt['id'])}}" target="_blank">
                                                            {{$pdt['name']}}
                                                        <p class="qiangrey"> 规格</p>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div  class= "price"  >
                                                    ￥{{$pdt['price']}}
                                                </div>
                                                <div class="num" >
                                                    {{$pdt['buy_number']}}
                                                </div>
                                                <div class="total" >
                                                   {{ $pdt['buy_number'] * $pdt['price'] }}
                                                </div>
                                            </div>
                                    </li>
                                   @endforeach
                                </ul>
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
<script src="/home/js/jquery.SuperSlide.2.1.1.js" type="text/javascript" ></script>
<!--End 轮播 End -->
<script>


    $("#slide-change").slide({ mainCell:".d-list", effect:"leftLoop",autoPage:true,scroll:7,vis:7});


</script>

</body>




</html>
