<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />

    <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>

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
        .dd-title .td1 { width:20%;text-align: center;}
        .dd-title .td2 { width:60%;text-align: center;}
        .dd-title .td3 { width:20%;text-align: center;}
        .dd-title p {display: inline-block;color:#828282; margin-right: 45px;}

        .dd-detail{   padding: 0; width:100%; background-color: #fff; }
        .dd-coll{ display: table; width:100%; border: 1px solid #eee; background-color: #fff;   }
        .dd-coll .more-pro{  width:60%; display: table-cell; text-align: center; vertical-align: middle;  }

        .dd-coll .num {width:20%;  display: table-cell;text-align: center;vertical-align: middle; }
        .dd-coll .total {width:20%; height:80px; display: table-cell;text-align: center;vertical-align: middle;}

        .re-old{
            border: 1px solid #ddd;
        }

        .re-current{
            border: 1px solid red;
        }

        .re{
          float: left;margin-left: 0px; width:70px;height:30px;  line-height: 30px; border-radius: 3px; cursor: pointer;
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
                <div class="dingdan" >
                    <div class="dd-list">
                        <div class="dd-title">
                            <ul >
                                <li class="td1">订单号</li>
                                <li class="td2" style="text-align: left;">商品名称</li>
                                <li class="td3">数量</li>
                            </ul>
                        </div>
                        <div class="dd-detail">
                                @foreach( $orderDetail['pdt'] as $pdt)
                                        <div class="dd-coll" style="float:left; "  >
                                            <div class="total" >
                                                {{$orderDetail['order_sn']}}
                                            </div>
                                            <div class="more-pro" style=" ">
                                                <a   href="{{url('product/' . $pdt['id'])}} "style="float: left; width:120px; height:120px;display: inline-block;">
                                                    <img src="{{url($pdt['preview'])}}"  style="width:120px; height:120px; ">
                                                </a>
                                                <div style=" float:left; margin-right: 0px; text-align: left;padding: 0 0 0 15px;">
                                                    <a href="{{url('product/' . $pdt['id'])}}" target="_blank">
                                                        {{$pdt['name']}}
                                                        @if($pdt['spec_name'] !='')
                                                            <p class="qiangrey">
                                                                @foreach($pdt['spec_name'] as $spec )
                                                                    [{{$spec}}]
                                                                @endforeach
                                                            </p>
                                                        @endif
                                                        <input  type="hidden" name="order_sn"  value="{{$pdt['order_son_sn']}}">
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="num" >
                                                     {{$pdt['buy_number']}}
                                            </div>
                                        </div>
                                @endforeach
                        </div>
                    </div>
                </div>

                <div class="wuliu-detail" style="margin-top: 20px;">
                    <div style="padding: 20px 60px 20px 60px ; float: left; ">
                        <ul >
                            <li style="width:100%; float: left; margin-top: 10px;">
                                <input type="hidden"  name="re_type" id="re_type" value="1"  >
                               <p style=" float: left;">
                                   <em style="color:red;">*</em>
                                   服务类型:
                               </p>
                                <div style=" margin-left: 20px; float: left;  ">
                                   <div id="re-new" class="re re-old re-current"   type_id="1"  >
                                       <span> 我要换货</span>
                                   </div>
                                   <div id="re"   class="re re-old" style="margin-left: 10px;" type_id="2">
                                       <span> 我要退货</span>
                                   </div>
                               </div>
                           </li>
                            <li style="width:100%; float: left; margin-top: 10px;">
                                <p style=" float: left;">
                                    <em style="color:red;">*</em>
                                    提交数量:
                                </p>
                                <div style=" margin-left: 20px; float: left;  ">
                                    <div class="c_num" style="float: left;">
                                        <input type="button" value=""   class="car_btn_1 reduce"  />
                                        <input type="text" value="1" data-max=" {{$orderDetail['pdt'][0]['buy_number']}}"   class="car_ipt result"/>
                                        <input type="button" value="" class="car_btn_2 add"  id="add"/>
                                    </div>
                                </div>
                            </li>
                            <li style="width:100%; float: left; margin-top: 10px;">
                                <p style=" float: left;">
                                    <em style="color:red;">*</em>
                                    问题描述:
                                </p>
                                <div style=" margin-left: 20px; float: left;  ">
                                    <div class="" style="float: left;">
                                        <textarea  id="why"  style="width:700px; height:200px ; border:1px solid #ddd; "  placeholder=""></textarea>
                                    </div>
                                </div>
                            </li>
                            <li style="width:100%; float: left; margin-top: 10px;">
                                <p style=" float: left;">
                                    <em style="color:red;"></em>
                                    图片信息:
                                </p>
                                <div style=" margin-left: 20px; float: left;  ">
                                    <div class="" style="float: left;">
                                        <div style=" float: left; margin-left: 10px;" class="re-picbox" >
                                            <i class="is_del " id="is_del"   onclick="del_img(this)">X</i>
                                            <div class="formControls col-xs-8 col-sm-9" style="float: left; margin-left: 10px;">
                                                <img class="img" id="preview_id" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 60px; height: 60px;" onclick="$('#input_id').click()" />
                                                <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','','images', 'preview_id');" />
                                            </div>
                                        </div>
                                        <div style=" float: left; margin-left: 10px;" class="re-picbox" >
                                            <i class="is_del " id="is_del"   onclick="del_img(this)">X</i>
                                            <div class="formControls col-xs-8 col-sm-9" style="float: left; margin-left: 10px;">
                                                <img class="img" id="preview_id1" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 60px; height: 60px;" onclick="$('#input_id1').click()" />
                                                <input type="file" name="file" id="input_id1" style="display: none;" onchange="return uploadImageToServer('input_id1','','images', 'preview_id1');" />
                                            </div>
                                        </div>
                                        <div style=" float: left; margin-left: 10px;" class="re-picbox" >
                                            <i class="is_del " id="is_del"   onclick="del_img(this)">X</i>
                                            <div class="formControls col-xs-8 col-sm-9" style="float: left; margin-left: 10px;">
                                                <img class="img" id="preview_id2" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 60px; height: 60px;" onclick="$('#input_id2').click()" />
                                                <input type="file" name="file" id="input_id2" style="display: none;" onchange="return uploadImageToServer('input_id2','','images', 'preview_id2');" />
                                            </div>
                                        </div>

                                        <div style="vertical-align: bottom; float:left; margin-left: 20px;">
                                            <span style="margin-bottom:  2px; ">(可上传3张图片)</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div style="float:left;  width:100%;  background-color: #fff; padding: 20px; text-align: center;">

                    <input   type="button" value=" 提交申请"    onclick="toappply();"  style="  width:90px; height:30px ; line-height: 30px; color:#fff; background-color: #007cc3; border:none; border-radius: 4px;">
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
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/js/uploadFile.js"></script>
<!--End 轮播 End -->
<script>

/*************begin****************/


$(function(){


});


$('.re').click(function(){
    if($(this).hasClass('re-current')){
        return;
    }else{
        var t = $(this).attr('type_id');
        $('#re_type').val(t);
        $(this).addClass('re-current');
        $(this).siblings().removeClass('re-current');
    }

});



/*************begin****************/
    //+
    $('.add').click(function(){
        computeNum($(this),'add');
        $(this).siblings(".result").trigger("change");
    });
    //-
    $('.reduce').click(function(){
        computeNum($(this),'reduce');
        $(this).siblings(".result").trigger("change");
    });
    //输入
    $(".result").keyup(function() {
        computeNum($(this), "");
    });
    //数量变化时，调整小计和产品数量和总价
    $(".result").change(function() {
        var p = $(this).parent().parent();//td
        var n =parseInt($.trim($(this).val()) );

    });


    //加减操作
    function computeNum(obj,act){
        var txtNum = (act == "" ? obj : obj.siblings(".result"));
        var max = txtNum.data('max');//获取库存量
        var n = parseInt($.trim(txtNum.val()));//当前购买数量
        n = isNaN(n)? 1: n;
        max = max|| 9999;
        if(max != 'undefined' && act =='add' && n <= max){
            n++;
        }else if(max != 'undefined' && act =='reduce' && n > 1) {
            n--;
        }
        if(n > max){
            n = max;
        }
        if(n < 1){
            n = 1;
        }
        txtNum.val(n);
    }
/***************end*********************/

/***************begin*********************/
    function  del_img(t){
        var  img = $(t).next().children('img')
        var imgIdSrc =  img.attr('src');
    $.get('/service/product/imgs_del',{'src':imgIdSrc},function(res){
        if(res.status == 0){
          //  alert('删除成功');
            $(t).removeClass('is-del-cur');
            img.attr('src',res.data.uri);
        }
    },'json');
}


//提交退货申请
    function toappply(){
        var img = [];
        var order_sn = $('input[name=order_sn]').val();
        var type = $('#re_type').val()   //退货申请类型
        var num = $('.result').val()  //退货数量
        var content = $('#why').val();
        img[0] = $('#preview_id').attr('src')=='/images/jia.png' ? '' :$('#preview_id').attr('src');
        img[1] = $('#preview_id1').attr('src')=='/images/jia.png' ? '' :$('#preview_id1').attr('src');
        img[2] = $('#preview_id2').attr('src')=='/images/jia.png' ? '' :$('#preview_id2').attr('src');
        if(content == ''){
            layer.msg('请填写理由', { time:2000});
            return;
        }
        $.get('/service/user',{ act:'return_apply',type:type,num:num,content:content,img:img,order_sn:order_sn},function(res){
            if(res.status == 0){
                layer.msg(res.message, { time:2000});
                setTimeout("window.location.href='/myservice' ", 2000);
            }else{
                layer.msg(res.message, { time:2000});
            }
        } ,'json');

    }



</script>

</body>




</html>
