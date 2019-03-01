@extends('home.master')
<link type="text/css" rel="stylesheet" href="/home/css/style.css" />
<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">
<style>

    .tim{
        color:red;
        font-size: 22px;
    }

    .jin{
        opacity:0.5; pointer-events:none;
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
<div class=" ">

<div class="list_c content  "  style="background-color: #fff;">
    <ul class="cate_list">
        @foreach($quanList as $v)
            <li    style="width:45%; height:180px;  background-color: #f6e5e2; border-radius: 15px;  "
            @if(!empty($userQuanId) && in_array($v['id'],$userQuanId) ) class=" jin quan-li  " @else class="quan-li"   @endif
            >
                <div class="img" style=" float:left; width:150px; height:150px;margin-top: 5px ; margin-left: 10px; margin-bottom: 5px;  "><a href=""><img src="/images/test1.jpg" style="width: 150px;height:150px; border-radius: 50%;"/></a></div>
                <div style="float: left;  width:45%;margin-left: 15px;  ">
                    <div  style="float:right; margin-top: 15px;     width: 100%;     ">
                        <a href="#" style="float: left;" > <span  style="font-size: 25px; color:#616161; "> {{$v['name']}} </span></a>
                    </div>
                    <div  style="float:left; margin-top: 20px; width: 100%; ">
                        <span  style="float: left; color:#aaa">已经被领取&nbsp;<b style="font-size: 14px; color:#616161;"  > {{$v['receive_num']}}</b>&nbsp;张 </span>
                    </div>
                    <div  style="float:left; margin-top: 30px; width: 100%;   ">
                        <span  style="float: left; color:#f66046;font-size: 20px;">￥<b style="color: #f66046;font-size: 30px;   "> 0</b> </span>
                        <span style="float: right; display: inline-block; padding: 5px; border:1px solid #ffc1c4; color:#ff7c65; margin-right: 20px; font-size: 20px;border-radius: 5px;"> {{$v['parvalue']}}元券 </span>
                    </div>
                </div>

                <div   class="yiling" style="float: right; width:100px ; height: 100%; border-left:3px dashed #fff;  background-color: rgba(250,237,255,1);cursor: pointer;"  onclick="getQuan(this,{{$v['id']}})"  >
                    @if(!empty($userQuanId) && in_array($v['id'],$userQuanId) )
                        <span  class="yi" style="float: left; font-size: 30px; width:100%;text-align: center; margin-top: 35px; color:#aaa">已</span>
                        <span  class="ling"  style="float: left; font-size: 30px; width:100%;text-align: center; margin-top: 35px; color:#aaa">领</span>
                     @else
                        <span  class="yi"    style="float: left; font-size: 30px; width:100%;text-align: center; margin-top: 35px; color:#007cc3">领</span>
                        <span  class="ling"  style="float: left; font-size: 30px; width:100%;text-align: center; margin-top: 35px; color:#007cc3">取</span>
                    @endif

                </div>
            </li>
        @endforeach
    </ul>
</div>
</div>
@endsection

@section('my-js')
    <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/home/js/menu.js"></script>
    <script type="text/javascript" src="/home/js/lrscroll_1.js"></script>
    <script type="text/javascript" src="/home/js/n_nav.js"></script>
    <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script>

    //领取优惠券
    function getQuan(t,id){

        $.get('/service/cate',{act:'quan_get',id:id},function (res) {
            if(res.status == 0){
                $(t).find('.yi').html('已');
                $(t).find('.ling').html('领');
                $(t).parents('.quan-li').addClass('jin');
            }
            layer.msg(res.message, {time:2000});
        },'json');
    }




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