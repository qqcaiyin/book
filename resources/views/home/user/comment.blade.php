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


        .hint{ background-image: none;}
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
                <form  method="get" action="{{url('/service/user')}}" onsubmit=" return check();" >
                    <input  type="hidden" name="act" value="comment">
                    <input  type="hidden" name="order_sn" value="{{$orderDetail['order_sn']}}">
                    <div class="wuliu-detail">
                        <h4 style="text-align: left; padding:10px 30px; border-bottom: 1px solid #ddd;">
                           评价订单
                            <span style="padding-left: 50px;">
                               订单号：  {{$orderDetail['order_sn']}}
                            </span>
                            {{$orderDetail['status_desc']}}
                        </h4>
                        @foreach($orderDetail['pdt'] as $pdt)
                            <div class = "l-appr ">
                                <input type="hidden" name="pdt_id[]" value="{{$pdt['id']}}">
                                <input type="hidden" name="spec[]" value="{{$pdt['product_attr']}}">
                                <div class="goods-appr">
                                    <div class="goods-pic ">
                                        <a>
                                            <img src="{{url($pdt['preview'])}}" >
                                        </a>
                                    </div>
                                    <div class="goods-desc">
                                        <a>{{$pdt['name']}}</a>
                                        <p>
                                            @foreach($pdt['spec_name'] as $spec)
                                                【{{$spec}}】
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                                <div class="comment-appr">
                                    <p><span style="color: red;">*</span>满意度</p>
                                    <div class="stars" id="star">
                                        <img src="{{ url('/images/star-grey-empyt.png ') }} "  alt="1"  title="1星,差评">
                                        <img src="{{ url('/images/star-grey-empyt.png ') }} "  alt="2" title="2星,不满意">
                                        <img src="{{ url('/images/star-grey-empyt.png ') }} " alt="3" title="3星,一般">
                                        <img src="{{ url('/images/star-grey-empyt.png ') }} "  alt="4" title="4星,比较满意">
                                        <img src="{{ url('/images/star-grey-empyt.png ') }} " alt="5" title="1星,非常满意">
                                    </div>
                                    <div class="hint" ></div>

                                    <div class="comment-msg">
                                        <p><span style="color: red;">*</span>商品评价</p>
                                        <div>
                                            <textarea name="content[]" maxlength="500" placeholder="分享购买心得~"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        @endforeach
                        <div style=" float:left ;text-align: center; width:100%; margin-top: 20px ;margin-bottom: 20px ;">
                            <input type="submit"  class="tj-comment" value="提交"   >
                            <span>
                             <input type="checkbox" name="anonymous" value="1" >匿名评论
                             </span>
                        </div>
                    </div>

                </form>
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

<!--bengin  bengin -->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script src="/home/js/jquery.raty.min.js" type="text/javascript"></script>
<script src="/home/js/jquery.raty.js" type="text/javascript"></script>


<!--End  End -->
<script>

    $('.stars').raty({
        iconRange: [{
            range: 1,
            on: '/images/star-red.png',
            off: '/images/star-grey-empyt.png'
        }, {
            range: 2,
            on: '/images/star-red.png',
            off: '/images/star-grey-empyt.png'
        }, {
            range: 3,
            on: '/images/star-red.png',
            off: '/images/star-grey-empyt.png'
        }, {
            range: 4,
            on: '/images/star-red.png',
            off: '/images/star-grey-empyt.png'
        }, {
            range: 5,
            on: '/images/star-red.png',
            off: '/images/star-grey-empyt.png'
        }],
        hints: ['1分 非常不满意', '2分 不满意', '3分 一般', '4分 比较满意', '5分 非常满意'],
        target: '.hint'
    });
    $(function() {
        $("#star img").each(function() {
            $(this).click(function () {
                var hint= $(this).parent().siblings(".hint");
                hint.css("background-image", hint.html() == ''? "none" : "url(/images/star-desc.png)");
            })
        });
    });



    function check() {
        if ($(".l-appr").length>1) {
            var is_fill= false;
            $(".l-appr").each(function() {
                var star = $(this).find("input[name='star[]']").val();
                var content = $(this).find("textarea[name='content[]']").val();
                if (star!='' && $.trim(content)!='') {
                    is_fill = true;

                   // return false;
                }
            });
            if (is_fill == false) {
                layer.msg('请至少对一件商品评价', {time:2000});
                return false;
            }
        } else{
            var star = $("input[name='star[]']").val();
            var content = $("textarea[name='content[]']").val();
            if (star =='') {
                layer.msg('请为商品满意度打分', {time:2000});
                return false;
            }
            if ($.trim(content) =='') {
                layer.msg('请填写评价内容', {time:2000});
                return false;
            }
        }

        return true;
    }



</script>

</body>




</html>
