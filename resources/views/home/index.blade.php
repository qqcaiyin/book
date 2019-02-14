@extends('home.master')

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
                    <div class="img"><a href="#"><img src="images/car1.jpg" width="58" height="58" /></a></div>
                    <div class="name"><a href="#">法颂浪漫梦境50ML 香水女士持久清新淡香 送2ML小样3只</a></div>
                    <div class="price"><font color="#ff4e00">￥399</font> X1</div>
                </li>

                <li>
                    <div class="img"><a href="#"><img src="images/car2.jpg" width="58" height="58" /></a></div>
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
        <span class="i_mores fr"><a href="javascript:void(0)">更多</a></span>
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
                                            <a href="{{url('/product/'. $hotProduct->id)}}"><img width="160" height="136" src="{{url($hotProduct->preview)}}"></a>
                                        </div>
                                        <div class="name">
                                            <a href="{{url('/product/'. $hotProduct->id)}}">
                                                <h2>{{$hotProduct->name}}</h2>
                                                {{$hotProduct->summary}}
                                            </a>
                                        </div>
                                        <div class="price">
                                            <font>￥<span>{{$hotProduct->price}}</span></font> &nbsp; 26R
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
        <span class="fl">家 电</span>
        <span class="i_mores fr">
            @foreach($floors as $floor)
            <a href="#">{{$floor->floor_name}}</a>&nbsp; &nbsp; &nbsp;
          @endforeach
        </span>
    </div>
    <div class="content">
        <div class="fresh_mid">
            <ul>

                @foreach($products as $fl)
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
    <!--End 进口 生鲜 End-->
    <div class="content mar_20">
        <img src="/images/fl2.jpg" width="1200" height="110" />
    </div>

    <div class="i_t mar_10">
        <span class="floor_num">1F</span>
        <span class="fl">家 电</span>
        <span class="i_mores fr">
            @foreach($floors as $floor)
                <a href="#">{{$floor->floor_name}}</a>&nbsp; &nbsp; &nbsp;
            @endforeach
        </span>
    </div>
    <div class="content">
        <div class="fresh_mid">
            <ul>

                @foreach($products as $fl)
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


</script>

@endsection