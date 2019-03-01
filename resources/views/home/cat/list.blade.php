<!DOCTYPE html >
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">
    <title>尤洪</title>
</head>
<style>


    body{
        background-color: #f6f6f6;
    }
</style>
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
    <div class="logo"></div>
    <div class="search">
        <form name="search" action="{{url('/cate') }}"  method="get">
            <input type="text"  id="words"  name="words" @if(isset($data['at']) && $data['at'] =='search') value="{{$data['words']}}" @else value=""@endif class="s_ipt" />
            <input type="submit" value="搜索" class="s_btn" />
            <input type="hidden" name="at"  value="search"  />
        </form>
        <span class="fl">
           @foreach($keywords as $keyword)
                <a href="#">{{$keyword->name}}</a>
            @endforeach
        </span>
    </div>

    <div class="i_car">
        <div class="car_t">购物车 [ <span class="cartinfo" >{{$cartItems['count']}}</span> ]</div>
        <div class="car_bg">
            <div style=" width:100%; height:30px;border-bottom: 1px solid #eee; background-color: #eee;" ></div>

            <ul class="cars" >
                    <li id="[id1]" data-spec = "[spec]" >
                        <div class="img" ><a href="#"><img src="[preview1]" width="58" height="58" /></a></div>
                        <div class="name"  style=" width:120px; "><a href="#">[name1]</a></div>
                        <div class="price"  style=" float: right;  width:110px; text-align: right; padding-right:4px; "><span style="color:#ff4e00; ">￥[price1] X [count1]</span><br>
                            <span class="del"  ><i class="icon ion-close-circled"></i></span>
                        </div>
                    </li>
            </ul>


            <div style=" float:left; width:100%;background-color: #eee; padding:0;">
                <div class="price_sum">共计:&nbsp; <span >￥</span><span class = 'cart-total'>{{$cartItems['amount']}}</span></div>
                <div class="price_a"><a href="{{url('/cart')}}">去结算</a></div>
            </div>
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
                                            <h2><img  style=" height:50px;width:50px;" src="{{$cs->preview}}"><a href="{{url('/home/cate/'. $cs->id)}}"  >{{$cs->name}}</a></h2>
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
    </div>
</div>
<!--End Menu End-->
<div class="i_bg">
    @if($cateParents !='')
    <div class="postion">
        <span class="fl">
            <a href="{{url('/')}}">首页</a>
                @foreach($cateParents as $cateParent)
                  ><a href="{{url('/home/cate?at=t2&id='.$cateParent->id)}}">  {{$cateParent->name}}</a>
                @endforeach
        </span>
    </div>
    @endif
    <!--Begin 筛选条件 Begin-->
    <div class="content mar_10" >
            <div class="filter-box">
                    <dl class="filter-list clearfix"  >
                        <dt style="float: left; width:100px;text-align: left;">分类：</dt>
                        @if($sonCates !='')
                        <dd  @if(isset($t3)) class="dd "@else class="active dd" @endif ><a href="{{url('/home/cate?at=t2&id='.$data['cate'])}}" >全部</a></dd>
                            @foreach($sonCates as $val)
                                <dd  @if( isset($data)&&($data['id'] == $val['id'])) class="dd active"@else class=" dd" @endif ><a href="{{url('/home/cate?at=t2&cate='.$data['cate']. '&id='. $val['id'])}}" >{{$val['name']}}</a></dd>
                            @endforeach
                        @endif
                    </dl>
                    <dl class="filter-list clearfix" style="vertical-align: middle; padding: 20px;">
                        <dt style="float: left; width:100px;text-align: left; ">品牌：</dt>
                        <dd class="active" style="float: left; width:180px;text-align: left;"><a  >全部</a></dd>
                        <dd style="float: left; width:180px;text-align: left;"><a>小米</a></dd>
                        <dd class="active" style="float: left; width:180px;text-align: left;">小黑</dd>
                    </dl>
            </div>
    </div>
    <!--End 筛选条件 End-->

    <div class="content mar_20">
        <div class="l_list">
            <div class="list_t">
            	<span class="fl list_or" style="width: 100%;" >
                	<a href="javascript:;"  onclick="orderTp(this)"  @if(isset($data['n']) && $data['n']=='newgood') class="now"   @endif data-tp="newgood"   id="newgood"  >新品</a><a style="color:#bbb;">|</a>
                    <a href="javascript:;" onclick="orderTp(this)"
                       @if(isset($data['n']) && $data['n']=='saleup') data-tp="saledown"
                       @else data-tp="saleup"
                       @endif
                        @if(isset($data['n']) && ($data['n']=='saleup'  || $data['n']=='saledown')) class="now"
                        @else
                                class=""
                        @endif
                    id="salenum" >
                    	<span class="fl">销量</span>
                        <span class="i_up">销量从低到高显示</span>
                        <span class="i_down" >销量从高到低显示</span>
                    </a>
                    <a style="color:#bbb;">|</a>
                    <a href="javascript:;" onclick="orderTp(this)"
                       @if(isset($data['n']) && $data['n']=='priceup') data-tp="pricedown"
                       @else data-tp="priceup"
                       @endif
                       @if(isset($data['n']) && ($data['n']=='priceup'  || $data['n']=='pricedown')) class="now"
                       @else
                       class=""
                       @endif
                       id="price">
                    	<span class="fl">价格</span>
                        <span class="i_up">价格从低到高显示</span>
                        <span class="i_down">价格从高到低显示</span>
                    </a>
                    <a style="color:#bbb;">|</a>
                    <a href="javascript:;" onclick="orderTp(this)" style=" " data-tp="comment"   id="comment">评论最多</a>
                </span>
                <span class="fr"></span>
            </div>
            <div class="list_c">
                <ul class="cate_list">
                    @foreach($products as $product )
                    <li>
                        <div class="img"><a href="{{url('/product/'. $product->id)}}"><img src="{{url($product->preview)}}" width="208" height="185" /></a></div>

                        <div class="name"><a href="#">{{$product->name}}</a></div>
                        <div class="price">
                            <font><span>￥{{$product->price}}</span></font> &nbsp; 26R
                        </div>
                        <div class="carbg">
                            <a href="javascript:;" @if(isset($myFav)&&in_array($product->id,$myFav))  class="ss-fav"  @else class="ss" @endif id="addFav"  onclick="addFav(this,{{$product->id}})">收藏</a>
                            <a class="j_car" href="javascript:;" onclick="addCart('{{$product->id}}',0,1,);" >   加入购物车</a>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <div class="pages"  >
                    {!!$products->render()!!}
                </div>

            </div>
        </div>
    </div>

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
        <div class="btm" >
            <a href="/" target="_blank">首页</a>| <a href="/n-about.html" target="_blank">关于我们</a>
            | <a href="/n-help.html" target="_blank">联系我们</a>
            | <a href="/n-help.html" target="_blank">帮助中心</a>
            <p>Copyright © 2015-2018  All Rights Reserved.  </p>
        </div>
    </div>
    <!--End Footer End -->>
</div>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/home/js/menu.js"></script>
<script type="text/javascript" src="/home/js/lrscroll_1.js"></script>
<script type="text/javascript" src="/home/js/n_nav.js"></script>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>

<script>

    //产品排序
    $('#newgood').click(function(){
        if($(this).hasClass('now')){

        }
        $(this).addClass('now');
        $(this).siblings('a').removeClass('now');



    });

        function orderTp(t){
           var n =  $(t).data('tp');
            $(t).addClass('now');
            $(t).siblings('a').removeClass('now');

            var words = $.trim($('#words').val());
            var at='';
            if(words !=''){
              at='search'
            }

            location.href='/cate?at='+at+'&words='+words+'&n='+n;
         //   $.get('/cate' ,{at:at,words:words,n:n},function(res){
//
        //    } ,'json'  )



        }







    //添加收藏
    function addFav(obj,id){
        var t =$(obj);
        var act = 'add_fav';
        if(t.hasClass('ss-fav')){
            act ='del_fav';
        }
        $.get('/service/user' ,{ act:act,gid:id} ,function (data) {
            if(data.status == 0){
                if(act =='add_fav'){
                    layer.msg('收藏成功', {time:2000});
                    t.removeClass('ss').addClass('ss-fav');
                }
                if(act =='del_fav'){
                    layer.msg('取消收藏', {time:2000});
                    t.removeClass('ss-fav').addClass('ss');
                }

            }else if(data.status == 20){
                layer.msg('请先登陆', {time:2000});
              //  setTimeout("window.location.href='/login' ", 2000);
            }else{
                layer.msg(data.message, {time:2000});
            }

        } ,'json');
    }

    $(function() {
        //购物车
        $(".car_t").mouseover(function () {

            show_cartinfo($(this));

        });

        var carthtml = $(".car_bg ul").html();

        function show_cartinfo(obj) {
          //  $(".car_bg").html("");
            $.get('/service/cart', {act: 'get_cart'}, function (res) {
                if (res.status == 0) {
                    $('.cartinfo').html(res.data.count);//购物车总数
                    $('.cart-total').html(res.data.amount);//购物车总数
                    var $html = '';

                    if (res.data != false) {
                        $.each(res.data.products, function (k, v) {
                            $html += carthtml;
                            $html = $html.replace(/\[id1\]/g, v.cart_pdt.id).replace(/\[preview1\]/g, v.cart_pdt.preview).replace(/\[name1\]/g, v.cart_pdt.name).replace(/\[price1\]/g, v.cart_pdt.price).replace(/\[count1\]/g,v.count).replace(/\[spec\]/g,v.cart_pdt.spec);
                        });
                    }
                    $(".car_bg ul").html($html);
                   //  alert($html);
                    //移除商品
                    $(".del").each(function() {
                        $(this).click(function() {
                            var p = $(this).parents("li");
                            var id = p.attr("id");
                            var spec = p.data("spec");
                            removeGoods(id,p,spec);
                        });
                    });
                }
            }, 'json');
        }

    });
    //加入购物车
    function addCart(gid,direct,num,spec) {
        $.get('/service/cart', {
            act: 'add_cart',
            gid: gid,
            spec: spec,
            type: 0,
            num: num,
            direct: direct }, function (res) {
            if(res.status == 0){
                layer.msg('加入购物车成功', {time:2000});
               $('.cartinfo').html(res.count);
            }else{
                layer.msg(res.message, {time:2000});
            }
        },'json');
    }



//购物车移除商品
    function removeGoods(id,p,spec) {

        $.get('/service/cart',{act:'remove_products',gid:id,spec:spec},function(res){
            if(res.status ==0){
                layer.msg('移除成功', {time:2000});
                $('.cartinfo').html(res.count);
                p.remove();
            }

    },'json');

/*
        $.getJSON("/cart", {
            act: 'remove_goods',
            gid: ids,
            spec: spec
        }, function(res) {
            if (res.err != '') {
                msg("删除失败，" + res.err);
            } else {
                msg("删除成功");
                $(".cartinfo").html(res.res);
                var list = ids.split("@");
                $.each(list, function (k, v) {
                    $("#" + v).remove();
                });
            }
        });*/
    }
</script>
</body>
</html>