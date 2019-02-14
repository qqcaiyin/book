<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />
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

    <title>..</title>
    <style>
        <!-- -->
        .cart-buy{
            display: block;
            float:left;
            width:198px;
            height:48px;
            border:2px solid #007cc3;
            font-size: 16px;
            margin-left: 15px;
            text-align: center;
            line-height: 48px;
            vertical-align: middle;
            color:#fff;
            background-color:#007cc3;
            text-decoration: none;
        }
        .cart-buy1{
            display: block;
            float:left;
            width:198px;
            height:48px;
            border:2px solid #007cc3;
            font-size: 16px;
            margin-left: 15px;
            text-align: center;
            line-height: 48px;
            vertical-align: middle;
            color:#007cc3;
            background-color:#edf9ff;
            text-decoration: none;
        }
        .cart-buy:link{
            cursor: pointer;
            color: #fff;
        }
        .cart-buy:hover{
            color: #fff;
        }
        .cart-buy1:link{
            cursor: pointer;
            color:#007cc3;
        }
        .cart-buy1:hover{
            color:#007cc3;
        }
        .no-stock{
            color:#ddd;
        }

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
                                            <h2><img  style=" height:40px;width:40px;" src="{{$cs->preview}}"><a href="{{url('/home/catelist/'. $cs->id)}}"  >{{$cs->name}}</a></h2>
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
<div class="i_bg">
    <div class="postion">
         <span class="fl">
            <a href="{{url('/home/index/')}}">全部</a>>
             @foreach($cateParents as $cateParent)
                 <a href="{{url('/home/cate/'.$cateParent->id)}}">  {{$cateParent->name}}</a>>
             @endforeach
             {{$productInfo->name}}
        </span>
    </div>
    <div class="content">
        <div id="tsShopContainer">
            <div id="tsImgS"><a href="{{$productInfo->images[0]->image_path}}" title="Images" class="MagicZoom" id="MagicZoom"><img src="{{$productInfo->images[0]->image_path}}" width="390" height="390" /></a></div>
            <div id="tsPicContainer">
                <div id="tsImgSArrL" onclick="tsScrollArrLeft()"></div>
                <div id="tsImgSCon">
                    <ul >
                        @foreach($productInfo->images as $key => $img)
                        <li style ="display: inline;" onclick="showPic(0)" rel="MagicZoom" class="tsSelectImg" ><img src="{{$img->image_path}}" tsImgS="{{$img->image_path}}" width="79" height="79" /></li>
                        @endforeach

                    </ul>
                </div>
                <div id="tsImgSArrR" onclick="tsScrollArrRight()"></div>
            </div>
            <img class="MagicZoomLoading" width="16" height="16" src="" alt="Loading..." />
        </div>

        <div class="pro_des" >
            <div style="height:180px; width:100%; ">
                <div class="des_name" >
                    <p> {{$productInfo->name}}</p>
                    {{$productInfo->summary}}
                </div>
                @if($productInfo->is_sale == 1)
                <div class="des_price">
                    促销价：<b>￥{{$productInfo->sale_price}}</b><br />
                    促销时间：<b> {{date('Y-m-d',$productInfo->start_date)}}&nbsp;~&nbsp;{{ date('Y-m-d',$productInfo->end_date)}}</b>
                </div>
                @endif
            </div>
            <div class="des_price">
                本店价格：<b  @if($productInfo->is_sale==1)   style="text-decoration: line-through ; color:#ddd;" @endif> ￥{{$productInfo->price}}</b><br />
                商品库存：<span id="pdt_num">{{$productInfo->num}}</span>
            </div>
            <!--规格--->
            <div  style=" width:100%;">
            @foreach($attrList  as $spec)
                <div class="des_choice">
                    <span class="fl">{{$spec['name']}}：</span>
                    <ul>
                        @foreach($spec['spec'] as $v)
                            <li  class=" @if($v['is_stock']==0) no-stock  @endif  "   spec_id="{{$v['id']}}">{{$v['name']}}<div class="ch_img"></div></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
            </div>
<!--
            <div class="des_share">
                <div class="d_care"><a onclick="ShowDiv('MyDiv','fade')">关注商品</a></div>
            </div>
-->
            <!--加入购物车-->
            <div class="des_join">
                <div class="j_nums">
                    <input type="text" value="1" name="" class="n_ipt" />
                    <input type="button" value="" onclick="addUpdate(jq(this));" class="n_btn_1" />
                    <input type="button" value="" onclick="jianUpdate(jq(this));" class="n_btn_2" />
                </div>
                <span class="fl">
                    <a id= "Tobuy" class="cart-buy1" href="javascript:;" onclick="addToCart(1)" >立即购买</a>
                    <a id= "addToCate" class="cart-buy"  href="javascript:;" onclick="addToCart(0)">加入购物车</a>
                </span>

                <!--onclick="ShowDiv_1('MyDiv1','fade1')"--->
            </div>
        </div>

        <div class="s_brand">
            <div class="s_brand_img"><img src="{{$productInfo->images[0]->image_path}}" width="188" height="132" /></div>
            <div class="s_brand_c"><a href="#">推荐</a></div>
        </div>


    </div>
    <div class="content mar_20">
            <div class="des_border">
                <div class="des_tit">
                    <ul>
                        <li class="current" ids="p_attribute"><a   href="javascript:;">商品详情</a></li>
                        <li ids="p_comment"><a  href="javascript:;">商品评论</a></li>
                    </ul>
                </div>
            </div>

            <div id="ct">
            <!--商品详情-->
            <div class="des_con" id="p_attribute">

                <table border="0" align="center" style="width:100%; font-family:'宋体'; margin:10px auto;" cellspacing="0" cellpadding="0">
                    @foreach($specList as $value)
                        <tr>
                            <td>{{$value->name}}：{{$value->attr_value}}</td>
                        </tr>

                    @endforeach
                </table>
            </div>

            <!--商品评论-->
            <div class="des_border" id="p_comment" style=" display: none;">

                <table border="0" class="jud_tab" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="175" class="jud_per">
                            <p>80.0%</p>好评度
                        </td>
                        <td width="300">
                            <table border="0" style="width:100%;" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="90">好评<font color="#999999">（80%）</font></td>
                                    <td><img src="/home/images/pl.gif" align="absmiddle" /></td>
                                </tr>
                                <tr>
                                    <td>中评<font color="#999999">（20%）</font></td>
                                    <td><img src="/home/images/pl.gif" align="absmiddle" /></td>
                                </tr>
                                <tr>
                                    <td>差评<font color="#999999">（0%）</font></td>
                                    <td><img src="/home/images/pl.gif" align="absmiddle" /></td>
                                </tr>
                            </table>
                        </td>
                        <td width="185" class="jud_bg">
                            购买过雅诗兰黛第六代特润精华露50ml的顾客，在收到商品才可以对该商品发表评论
                        </td>
                        <td class="jud_bg">您可对已购买商品进行评价<br /><a href="#"><img src="/home/images/btn_jud.gif" /></a></td>
                    </tr>
                </table>



                <table border="0" class="jud_list" style="width:100%; margin-top:30px;" cellspacing="0" cellpadding="0">
                    <tr valign="top">
                        <td width="160"><img src="/home/images/peo1.jpg" width="20" height="20" align="absmiddle" />&nbsp;向死而生</td>
                        <td width="180">
                            颜色分类：<font color="#999999">粉色</font> <br />
                            型号：<font color="#999999">50ml</font>
                        </td>
                        <td>
                            产品很好，香味很喜欢，必须给赞。 <br />
                            <font color="#999999">2015-09-24</font>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="160"><img src="/home/images/peo2.jpg" width="20" height="20" align="absmiddle" />&nbsp;就是这么想的</td>
                        <td width="180">
                            颜色分类：<font color="#999999">粉色</font> <br />
                            型号：<font color="#999999">50ml</font>
                        </td>
                        <td>
                            送朋友，她很喜欢，大爱。 <br />
                            <font color="#999999">2015-09-24</font>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="160"><img src="/home/images/peo3.jpg" width="20" height="20" align="absmiddle" />&nbsp;墨镜墨镜</td>
                        <td width="180">
                            颜色分类：<font color="#999999">粉色</font> <br />
                            型号：<font color="#999999">50ml</font>
                        </td>
                        <td>
                            大家都说不错<br />
                            <font color="#999999">2015-09-24</font>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="160"><img src="/home/images/peo4.jpg" width="20" height="20" align="absmiddle" />&nbsp;那*****洋 <br /><font color="#999999">（匿名用户）</font></td>
                        <td width="180">
                            颜色分类：<font color="#999999">粉色</font> <br />
                            型号：<font color="#999999">50ml</font>
                        </td>
                        <td>
                            下次还会来买，推荐。<br />
                            <font color="#999999">2015-09-24</font>
                        </td>
                    </tr>
                </table>



                <div class="pages">
                    <a href="#" class="p_pre">上一页</a><a href="#" class="cur">1</a><a href="#">2</a><a href="#">3</a>...<a href="#">20</a><a href="#" class="p_pre">下一页</a>
                </div>

            </div>
            </div>

        </div>
    </div>


    <!--Begin 弹出层-收藏成功 Begin-->
    <div id="fade" class="black_overlay"></div>
    <div id="MyDiv" class="white_content">
        <div class="white_d">
            <div class="notice_t">
                <span class="fr" style="margin-top:10px; cursor:pointer;" onclick="CloseDiv('MyDiv','fade')"><img src="/home/images/close.gif" /></span>
            </div>
            <div class="notice_c">

                <table border="0" align="center"  cellspacing="0" cellpadding="0">
                    <tr valign="top">
                        <td width="40"><img src="/home/images/suc.png" /></td>
                        <td>
                            <span id="  " style="color:#3e3e3e; font-size:18px; font-weight:bold;">您已成功收藏该商品</span><br />
                            <a href="#">查看我的关注 >></a>
                        </td>
                    </tr>
                    <tr height="50" valign="bottom">
                        <td>&nbsp;</td>
                        <td><a href="#" class="b_sure">确定</a></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    <!--End 弹出层-收藏成功 End-->

    <!--Begin 弹出层-登陆层 Begin-->
    <div id="fade_login" class="black_overlay"></div>
    <div id="MyDiv_login" class="white_content">
        <div class="white_d">
            <div class="notice_t">
                <span class="fr" style="margin-top:10px; cursor:pointer;" onclick="CloseDiv('MyDiv_login','fade_login')"><img src="/home/images/close.gif" /></span>
            </div>
            <div class="notice_c">
                    <table border="0" align="center"  cellspacing="1" cellpadding="1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <tr valign="top">
                            <td width="80">用户名：</td>
                            <td>
                                <input  type="text" name="username"  autocomplete="off"    style="  height:25px; outline:none; border: 1px solid #ddd; background-color: white"  >
                            </td>
                        </tr>
                        <tr valign="top">
                            <td width="80">密码：</td>
                            <td>

                                <input  type="password" name="password"   autocomplete="off"   style="  height:25px; outline:none; border: 1px solid #ddd; background-color: white"  >
                            </td>
                        </tr>
                        <tr height="50" valign="bottom">
                            <td>&nbsp;</td>
                            <td><a href="javascript:;"  id="lg"  onclick="homeLogin();"  class="b_sure">确定</a></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><span   id="er"   style=" collapse: red;">    </span></td>
                        </tr>
                    </table>
            </div>
        </div>
    </div>
    <!--End 弹出层-登陆层 End-->


    <!--Begin 弹出层-加入购物车 Begin-->
    <div id="fade1" class="black_overlay"></div>
    <div id="MyDiv1" class="white_content">
        <div class="white_d">
            <div class="notice_t">
                <span class="fr" style="margin-top:10px; cursor:pointer;" onclick="CloseDiv_1('MyDiv1','fade1')"><img src="/home/images/close.gif" /></span>
            </div>
            <div class="notice_c">

                <table border="0" align="center"  cellspacing="0" cellpadding="0">
                    <tr valign="top">
                        <td width="40"><img src="/home/images/suc.png" /></td>
                        <td>
                            <span id="msg" style="color:#3e3e3e; font-size:18px; font-weight:bold;"></span><br />
                            <span id="data" style="color:#3e3e3e; font-size:12px; "></span>
                        </td>
                    </tr>
                    <tr height="50" valign="bottom">
                        <td>&nbsp;</td>
                        <td><a href="{{url('/home/cart/index')}}" class="b_sure">去购物车结算</a><a href="#" class="b_buy">继续购物</a></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    <!--End 弹出层-加入购物车 End-->
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

</body>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/home/js/menu.js"></script>
<script type="text/javascript" src="/home/js/lrscroll_1.js"></script>
<script type="text/javascript" src="/home/js/n_nav.js"></script>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript">

    var haveSpec = [];

     $(function(){

    // 选择规格
        $('.des_choice ul li').click(function(){
            if($(this).hasClass('no-stock')){
                return ;
            }
            //$(this).addClass('checked');
            if($(this).hasClass('checked')){
                $(this).removeClass('checked');

            }else{
                $(this).siblings().removeClass('checked');
                $(this).addClass('checked');
            }

            getSpec();
            if(!checkHasSpec()){
             return ;
            }

            var spec = haveSpec.join(',');
            console.log(haveSpec);
            var url='{{url('/service/product')}}';
            var gid='{{$productInfo->id}}';
            var num =$('.n_ipt').val();
            $.get(url,{ act:'sku_num','gid':gid,'spec':spec},function(res){
                if(res.status == 0){
                    //处理成功
                    $('#pdt_num').text(res.data);
                }else{
                    //
                }
                console.log(data);
            } ,'json')


        });

        //详情tab切换
        $('.des_tit ul li').click(function(){
            //标题添加样式
            $(this).addClass('current');
            $(this).siblings().removeClass('current');
            var s =$(this).attr('ids');
            //内容展示
            $('#ct').children().hide();
            $('#' +s).show();

        });

    //加入购物车点击事件
    $('#addToCa').click(function(){
        getSpec();
        if(!checkHasSpec()){
            layer.msg('请选择商品规格', {time:2000});
            return false;
        }

        var spec = haveSpec.join(',');
        console.log(haveSpec);
        var url='{{url('/service/cart')}}';
        var gid='{{$productInfo->id}}';
        var num =$('.n_ipt').val();
        $.get(url,{ act:'add_cart','gid':gid,'num':num,'spec':spec},function(res){
            if(res.status == 0){
                //处理成功
                layer.msg('添加成功', {time:2000});
            }else{
                //
                layer.msg(res.message, {time:2000});
            }
            console.log(data);
        } ,'json')
    });



     });
     //检测选中的规格
     function getSpec() {
         haveSpec=[];
         var speclist =$('.des_choice ul li');
         speclist.each(function(k,v){
             if(speclist.eq(k).hasClass('checked')){
                 //  console.log( speclist.eq(k).attr('spec_id'));
                 haveSpec.push(speclist.eq(k).attr('spec_id'));
             }
         })
     }

     //检测是否有规格
     function checkHasSpec(){
         var countSpec = $('.des_choice').length;
         if(haveSpec.length == countSpec){
             return true;
         }else{
             return false;
         }
         //  alert(len);
     }




     //加入购物车点击事件
     function addToCart( direct){
         getSpec();
         if(!checkHasSpec()){
             layer.msg('请选择商品规格', {time:2000});
             return false;
         }
         var spec = haveSpec.join(',');
         console.log(haveSpec);
         var url='{{url('/service/cart')}}';
         var gid='{{$productInfo->id}}';
         var num =$('.n_ipt').val();
         $.get(url,{ act:'add_cart','gid':gid,'num':num,'spec':spec},function(res){
             if(res.status == 0){
                 //处理成功
                 if(direct==1){
                     location.href = "/order";
                 }else{
                     layer.msg('添加成功', {time:2000});
                 }
             }else{
                 //
                 layer.msg(res.message, {time:2000});
             }
             console.log(data);
         } ,'json');
     }
     function  homeLogin(){
         var username = '';
         var password = '';
          username = $('input[name=username]').val();
          password = $('input[name=password]').val();

         if(username == '') {
             $('#er').html('账号不能为空');
             return false;
         }

         $.ajax({
           type:'post',
           url:'/home/login',
           dataType:'json',
           cache:false,
           data: {
               username: username,
               password: password,
               _token: "{{csrf_token()}}"
           },
             success: function(data) {
               if(data.status == 0){
                   //登陆成功
                   CloseDiv('MyDiv_login','fade_login');
                   return ;
               }else{
                   $('#er').html(data.message);
                   return ;
               }


           },
           error:function(xhr, status, error){
               console.log(xhr);
               console.log(status);
               console.log(error);
               $('#er').html(error);
           },
       });
     }


</script>
</html>
