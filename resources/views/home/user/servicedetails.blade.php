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
        .dd-title .td1 { width:10%;text-align: center;}
        .dd-title .td2 { width:10%;text-align: left;}
        .dd-title .td3 { width:50%;text-align: center; text-align: left;}
        .dd-title .td4 { width:10%;text-align: center;}
        .dd-title p {display: inline-block;color:#828282; margin-right: 45px;}


        .dd-detail{ display: table;  padding: 0; width:100%; background-color: #fff;text-align: center;  }
        .dd-detail div{ margin:0 auto;  }
        .dd-detail ul{  background-color: #fff; }
        .dd-detail ul li{  float:left; disply:table-cell; vertical-align: middle; border-bottom:1px dashed #ddd; text-align: center;  display: inline-block;}
        .dd-coll{ display: table; width:100%; border-bottom: 1px solid #eee;   }
        .dd-coll .more-pro{  width:10%; display: table-cell; text-align: left; vertical-align: top; float:left;  }

        .dd-coll .price { display: table-cell;width:40%;text-align: center; float:left;vertical-align: middle; }
        .dd-coll .num { display: table-cell;width:20%;text-align: center;float:left; vertical-align: middle;}
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
                    <div class= "lside" style="padding-top: 10px ;width: 100%;">
                       <div><span style =" float:left;   margin-left: 20px; width: 30%;">申请服务详情</span> </div>
                    </div>
                </div>
                <!--details -start--->
                <div style="background-color: #fff; width:100%; padding:4% 12%; float:left; ">
                    <p>
                        @if($applydetails['status'] == 1 )
                            @if($applydetails['shipping_status'] == 0 )
                                    请退货，并填写物流信息
                                    <span>还剩<b style="color:red;">{{$applydetails['days']}}</b> 天<b style="color:red;"> {{$applydetails['hours']}} </b>小时</span>
                            @else

                            @endif
                        @endif
                    </p>
                   <p>服务单号&nbsp; : <input  type="text" id="return_sn" readonly="readonly" style="border: none;" value="{{$applydetails['return_sn']}}">
                       <span style="margin-left: 30px;">
                           状态 :
                           <b style="margin-left:10px ; color: #0BB20C; font-weight: bolder; font-size: 16px; " >
                              @if($applydetails['status'] == 0)待审核
                               @elseif($applydetails['status'] == 1)
                                  @if($applydetails['shipping_status'] == 0)
                                   审核通过
                                  @elseif($applydetails['shipping_status'] == 1)
                                   等待商家收货
                                  @endif
                               @elseif($applydetails['status'] == 2)审核拒绝
                               @elseif($applydetails['status'] == 3)已取消申请
                               @endif
                           </b>
                       </span>
                       <span style="margin-left: 30px;">
                           申请时间&nbsp; :
                           {{date('Y-m-d H:i:s',$applydetails['apply_time'] ) }}
                       </span>
                       @if($applydetails['status'] != 3)
                       <a  style=" display:inline-block;    width:77px; height:26px; border-radius: 3px; text-align: center; line-height: 26px; font-size: 12px;border:1px solid red;"   href="javascript:;" onclick="cancel_service(this,{{$applydetails['return_sn']}})">撤销申请</a>
                       @endif
                   </p>
                    <div style="float:left; width:70%;margin-top: 20px; border:1px solid #ffccaa; background: #fffcf1; border-radius: 3px; padding: 6px;">
                        处理结果 &nbsp; :
                        @if($applydetails['status'] == 0)
                        @elseif($applydetails['status'] == 1)
                            审核通过,请把货品寄回商家。{{ date('Y-m-d H:i:s ',$applydetails['audit_time']) }}
                            <P> 商家收货地址 ： <span> 北京市，朝阳区，xxxx，王李伟，1771002933</span></P>
                        @elseif($applydetails['status'] == 2)审核拒绝- {{ date('Y-m-d H:i:s ',$applydetails['audit_time']) }}
                        @elseif($applydetails['status'] == 3)已取消申请 - {{ date('Y-m-d H:i:s ',$applydetails['cancel_time']) }}
                        @endif
                    </div>
                    <div style="float: left; width:70%; margin-top: 20px; ">
                       <p style="border-bottom: 1px dashed #ddd;">
                           商品：
                           <a>
                               <img  style=" height:50px;width:50px;"  src="{{url($applydetails['preview'])}}">
                           </a>
                           <a  >
                               {{$applydetails['product_name']}} [{{$applydetails['spec_value']}}]
                           </a>

                       </p>
                        <p style="border-bottom: 1px dashed #ddd;">
                            数量：{{$applydetails['product_num']}}
                        </p>
                        <p style="border-bottom: 1px dashed #ddd;">
                            类型：
                            @if($applydetails['state'] == 1)[换货]
                            @elseif($applydetails['state'] == 2)[退货]
                            @endif
                        </p>
                        <p style="border-bottom: 1px dashed #ddd;">
                            <span  >问题描述：</span>
                                {{$applydetails['why']}}
                            <br>
                            @foreach($applydetails['img'] as $img)
                            <img style="width:100px;height:100px; border:1px solid #eee;" src={{url($img['image_path'])}}>
                            @endforeach
                        </p>
                    </div>
                    <!----提交快递单号，上传快递照片----->
                    @if($applydetails['status'] == 1 && $applydetails['shipping_status'] == 0)
                    <div  style=" float:left; border:0px solid #ffccaa; border-radius: 3px; width:70%; margin-top:20px; padding-left: 20px;padding-top: 20px; ">
                      <div style="float: left; " >
                          <span style=" display:inline-block; width:100px;text-align: left; " >填写快递单号 ：</span>
                          <input type="text"    id="shipping_sn"  maxlength="14" name="shipping_sn" style="height: 25px ;border: 1px solid #ddd;">
                          <a  id="tj-shipping"   href="javascript:;"  style=" display:inline-block;  width:77px; height:25px; margin-left: 10px; border-radius: 3px; text-align: center; line-height: 25px; font-size: 12px;border:1px solid #007cc3; color:#007cc3;">提交</a>
                      </div>
                        <div style=" float:left;width:100%;  margin-top: 10px; " >
                            <span style=" float: left; display:inline-block;  width:100px; text-align: left;">上传快递单 ：</span><br>
                            <div style=" width:100%; "  class="re-picbox  " >
                                <i class="is_del " id="is_del"   onclick="del_img(this)">X</i>
                                <div class="" style="float: left; width: 100%">
                                    <img class="img" id="preview_id" src="/images/jia.png" style="border: 1px dashed #B8B9B9; width: 100%; height: 400px;" onclick="$('#input_id').click()" />
                                    <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','','images', 'preview_id');" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if( $applydetails['shipping_status'] == 1)
                        <div  style=" float:left; border:0px solid #ffccaa; border-radius: 3px; width:70%; margin-top:20px; padding-left: 20px;padding-top: 20px; ">
                            <div style=" float:left;width:100%;  margin-top: 10px; " >
                                <div style=" width:100%; "  class="re-picbox  " >
                                    <i class="is_del " id="is_del"   onclick="del_img(this)">X</i>
                                    <div class="" style="float: left; width: 100%">
                                        <img class="img" id="preview_id" src="{{$applydetails['shipping_img']}}" style="border: 1px dashed #B8B9B9; width: 100%; height: 400px;" />

                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif
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

<!--bengin js  bengin -->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/js/uploadFile.js"></script>
<!--End js End -->
<script>

    function  cancel_service(t,sn){
        if(!sn){
            return;
        }
        $.get('/service/user',{act:'cancel_service',sn:sn} , function(res){
            if(res.status ==0){
                layer.msg('取消成功', { time:2000});
               location.href='/';
            }else{
                layer.msg('取消失败', { time:2000});
                return;
            }

        },'json');
    }

//删除图片
    function  del_img(t){
        var  img = $(t).next().children('img')
        var imgIdSrc =  img.attr('src');
        $.get('/service/product/imgs_del',{'src':imgIdSrc},function(res){
            if(res.status == 0){
                //  alert('删除成功');
                $(t).removeClass('is-del-cur');
                img.attr('src',res.data.uri);
                layer.msg('删除成功', { time:2000});
            }
        },'json');
    }

    $('#tj-shipping').click(function(){
        var return_sn = $('#return_sn').val()   //shipping_sn退货单号
        var  shipping_sn= $('#shipping_sn').val()  //退货数量
        var img = $('#preview_id').attr('src')=='/images/jia.png' ? '' :$('#preview_id').attr('src');
        if(shipping_sn == '' ||  !is_enAndnum(shipping_sn)){
            layer.msg('请确认填写的快递单号正确', { time:2000});
            return;
        }
        if(img == ''){
            layer.msg('请上传快递单照片', { time:2000});
            return;
        }
        $.get('/service/user',{ act:'return_shipping_sn',return_sn:return_sn,shipping_sn:shipping_sn,img:img},function(res){
            if(res.status == 0){
                layer.msg(res.message, { time:2000});
                setTimeout("window.location.href='/myservice' ", 2000);
            }else{
                layer.msg(res.message, { time:2000});
            }
        } ,'json');
    });

    //英文字母和数字 6到20位
    function is_enAndnum(v) {
        return /^[A-Za-z0-9]{10,14}$/.test(v);
    }
</script>

</body>




</html>
