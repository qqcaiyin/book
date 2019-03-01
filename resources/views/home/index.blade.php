@extends('home.master')
<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">
<style>

    .tim{
        color:red;
        font-size: 22px;
    }
</style>

@section('content')
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
            <input type="text" name="words" value="" class="s_ipt" />
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
            <div class="leftNav">
                <ul>
                    @foreach($categories as $category)
                    <li>
<!--Begin 一级分类 Begin-->
                        <div class="fj">
                            <span class="n_img"><span></span></span>
                            <span class="fl">{{$category->name}}</span>
                        </div>
<!--Begin 二级分类 Begin-->
                        <div class="zj" >
                            <div class="zj_l">
                                @foreach($category->son as $cs )
                                <div class="zj_l_c">
                                    <h2><img  style=" height:40px;width:40px;" src="{{$cs->preview}}"><a href="{{url('/cate?at=t2&id=' .$cs->id)}}"  >{{$cs->name}}</a></h2>
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
        <ul class="menu_r" >
            @foreach($navs as $nav)
            <li><a href="{{url($nav->url)}}">{{$nav->name}}</a></li>
           @endforeach
        </ul>
        <div class="m_ad"></div>
    </div>
</div>
<!--End Menu End-->
<div class="i_bg bg_color">
    <div class="i_ban_bg">
        <!--Begin Banner Begin-->
        <div class="banner">
            <div class="top_slide_wrap">
                <ul class="slide_box bxslider">
                    <li><img src="/images/xmad_15476374946177_ZTGJq.jpg" width="1000" height="401" /></li>
                    <li><img src="/images/xmad_2.jpg" width="1000" height="401" /></li>
                    <li><img src="/images/xmad_15476374946177_ZTGJq.jpg" width="1000" height="401" /></li>
                </ul>
                <div class="op_btns clearfix">
                    <a href="#" class="op_btn op_prev"><span></span></a>
                    <a href="#" class="op_btn op_next"><span></span></a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            //var jq = jQuery.noConflict();
            (function(){
                $(".bxslider").bxSlider({
                    auto:true,
                    prevSelector:jq(".top_slide_wrap .op_prev")[0],nextSelector:jq(".top_slide_wrap .op_next")[0]
                });
            })();
        </script>
    </div>
        <!--End Banner End-->

    <!--Begin 限时抢购 Begin-->
    <div class="i_t mar_10">
        <span class="fl" style="color: red;  ">现时秒杀 </span>
        <span  data-time="111124" class="fl time" id="time1"   style="margin-left: 40px;" >
            还剩
            <span class="tim" id="day1">   </span>
            天
             <span class="tim"id="hour1">   </span>
            小时
             <span class="tim"id="minute1">    </span>
            分
             <span class="tim"id="second1">   </span>
            秒
        </span>
        <span class="i_mores fr"><a href="javascript:void(0)">更多&nbsp; &nbsp; &nbsp;</a></span>
    </div>
    <div class="like">
        <div id="featureContainer1">
            <div id="feature1">
                <div id="block1">
                    <div id="botton-scroll1" style="visibility: visible; overflow: hidden; position: relative; z-index: 2; ">
                        <ul class="featureUL" style="margin: 0px; padding: 0px; position: relative; list-style-type: none; z-index: 1;">
                            @foreach($hotProducts as $hotProduct)
                                <li class="featureBox" style="overflow: hidden; float: left; width: 238px; height: 228px;">
                                    <div class="box">

                                        <div class="imgbg">
                                            <a href="{{url('/product/'. $hotProduct['id'])}}"><img width="160" height="136" src="{{url($hotProduct['preview'])}}"></a>
                                        </div>
                                        <div class="name">
                                            <a href="{{url('/product/'. $hotProduct['id'])}}">
                                                <h2>{{$hotProduct['name']}}</h2>
                                                {{$hotProduct['summary']}}
                                            </a>
                                        </div>
                                        <div class="price">
                                            <font>￥<span>{{$hotProduct['price']}}</span></font> &nbsp; 26R
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
    <!--END 热门商品 END -->


    <div class="content mar_20">
        <img src="/images/xmad_15471302447392_lWdEk.jpg" width="1200" height="110" />
    </div>
    <!--Begin 楼层   家电 Begin-->
    <div class="i_t mar_10">
        <span class="floor_num">1F</span>
        <span class="fl">手 机</span>
        <span class="i_mores fr">
            @foreach($allfloors[2] as  $floor)
                <a href="#">{{$floor['floor_name']}}</a>&nbsp; &nbsp; &nbsp;
            @endforeach
            <a href="{{url('/cate?at=t2&id=1')}}">更多</a>&nbsp; &nbsp; &nbsp;
        </span>
    </div>
    <div class="content">
        <div class="fresh_mid">
            <ul>

                @foreach($products[2] as $fl)
                    @foreach($fl['product'] as  $key =>$value)
                <li>
                    <div class="name"><a href="{{url('/cate?at=t2&id=1')}}">{{$value['name']}}</a></div>
                    <div class="price">
                        <font>￥<span>{{$value['price']}}</span></font> &nbsp; 26R
                    </div>
                    <div class="img"><a href="{{url('/product/'. $value['id'])}}"><img src="{{url($value['preview'])}}" width="185" height="155" /></a></div>
                </li>
                    @endforeach
                @endforeach

            </ul>
        </div>
    </div>
    <!--End  End-->
    <div class="content mar_20">
        <img src="/images/fl2.jpg" width="1200" height="110" />
    </div>

    <div class="i_t mar_10">
        <span class="floor_num">2F</span>
        <span class="fl">家 电</span>
        <span class="i_mores fr">
                @foreach($allfloors[1] as  $floor)
                    <a href="#">{{$floor['floor_name']}}</a>&nbsp; &nbsp; &nbsp;
                @endforeach
                <a href="{{'/cate?at=t2&id=1'}}">更多</a>&nbsp; &nbsp; &nbsp;
        </span>
    </div>
    <div class="content">
        <div class="fresh_mid">
            <ul>

                @foreach($products[1] as $fl)
                    @foreach($fl['product'] as  $key =>$value)
                        <li>
                            <div class="name"><a href="#">{{$value['name']}}</a></div>
                            <div class="price">
                                <font>￥<span>{{$value['price']}}</span></font> &nbsp; 26R
                            </div>
                            <div class="img"><a href="{{url('/product/'. $value['id'])}}"><img src="{{url($value['preview'])}}" width="185" height="155" /></a></div>
                        </li>
                    @endforeach
                @endforeach

            </ul>
        </div>
    </div>
    <!-- Begin 广告 Begin -->
    <div class="content mar_20">
        <img width="1200" height="110" src="/home/images/mban_1.jpg">
    </div>
    <!-- End 广告 End -->


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

@endsection

@section('my-js')

<script>

  function dealData(id,val){
      $('#'+id).html(val)
  }

//倒计时
  window. setInterval(function(){
      SetRemainTime(1);

  },1000);

  function SetRemainTime(n) {
      //n = n || '';
      var SysSecond = parseInt($("#time"+n).data("time"));

      if (SysSecond > 0) {
          SysSecond = SysSecond - 1;
          var second = Math.floor(SysSecond % 60);
          var minute = Math.floor((SysSecond / 60) % 60);
          var hour = Math.floor((SysSecond / 3600) % 24);
          var day=Math.floor((SysSecond / 86400));
          $("#hour"+n).html( hour);
          $("#minute"+n).html( minute);
          $("#second"+n).html( second);
          $("#day"+n).html(day)
          $("#time"+n).data("time", SysSecond);
      } else {
          /* window.clearInterval(InterValObj+n);  */

      }
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

@endsection