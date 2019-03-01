<!DOCTYPE html >
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <title>订单结算</title>
    <style>
        .topay{
            display: block;
            width:120px;
            height:40px;
            line-height: 40px;
            font-size: 16px;
            text-align: center;
            vertical-align: middle;
            color:#fff;
            background-color:#007cc3;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 4px;
        }
        .topay:link{
            cursor: pointer;
            color: #fff;
        }
        .topay:hover{
            color: #fff;
        }
        body{
        }
    </style>
</head>
<body >
<!--Begin Header Begin-->
<div class="soubg" style=" height:100px;border-bottom: 1px solid #eee; ">
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
<!--End Menu End-->
<div class="i_bg">
    <form method="post" action="{{url('/home/order/action')}}"   id="form-order">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <!--Begin 第二步：确认订单信息 Begin -->
    <div class="content mar_20">
        <div class="cart-step">
            <ul>
                <li  class="cart1"> <i></i>购物车 </li>
                <li  class="oncart2 active"> <i></i>确认订单 </li>
                <li  class="cart3"> <i></i>付款</li>
                <li  class="cart4"> <i></i>支付成功</li>
            </ul>
        </div>

        <div class="two_bg">
            <div class="two_t">
                <span class="fr"><a href="{{url('/cart')}}">返回购物车修改</a></span><h4>商品列表</h4>
            </div>
            <table border="0" class="car_tab" style="width:1110px;" cellspacing="0" cellpadding="0">
                <tr >
                    <td class="car_th" width="550">商品名称</td>
                    <td class="car_th" width="300">属性</td>
                    <td class="car_th" width="150">单价</td>
                    <td class="car_th" width="130">数量</td>
                    <td class="car_th" width="140">小计</td>
                </tr>
                @foreach($cartList as $value)
                    <tr  id="{{$value['cart_pdt']['id']}}"  class="cart-pdt"  style="background-color:#fff;">
                        <td>
                            <div class="c_s_img"><img src="{{url($value['cart_pdt']['preview'])}}" width="73" height="73" /></div>
                           {{$value['cart_pdt']['name']}}
                        </td>
                        <td align="center">
                            @if(isset($value['cart_pdt']['spec_name'] ))
                            @foreach($value['cart_pdt']['spec_name'] as $v)
                                [{{$v }}]<br>
                            @endforeach
                            @endif
                        </td>
                        <td align="center">￥{{$value['cart_pdt']['price']}}</td>
                        <td align="center">{{$value['count']}}</td>
                        <td align="center" style="color:#ff4e00;">￥{{$value['sum']}}</td>
                    </tr>
                @endforeach

            </table>
            <div class="two-t0">
                <div class="two_t">
                    <span class="fr"><a href="javascript:;" id="changeAddr" onclick="changeAddr();"></a></span><h4>收货人信息</h4>
                </div>

                <div>
                    <div class="sh-address">
                        <ul>
                            <!- ----遍历已有地址  begin   -->
                            @if($data)
                                @foreach($data as $val)
                                    <li class="other-add default-add" id="30" data-cityid="110100">
                                        <div class="add-box" >
                                            <span class="remove vivi-blue" onclick="removeAddr(this, {{$val['id']}})">X</span>
                                            <div class="name-add">
                                                <span class="name">{{$val['consignee']}}</span>
                                                <span style="float:right; display:inline-block;"></span>
                                            </div>
                                            <div class="add-detail">
                                                <p class="name"> {{$val['province']}}{{$val['city']}}{{$val['district']}}</p>
                                            </div>
                                            <div>
                                                <span class="moblie">{{$val['moble']}}</span>
                                                <span style="margin-left: 10px; ">@if($val['is_default']==1)默认地址@endif</span>
                                                <a class="change-default change vivi-blue"   href="javascript:;" onclick="addEditAddr('/address_add?act=edit_addr&id={{$val['id']}}' );"> 修改</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                            <!- ----遍历已有地址    end -->
                            <!- ----添加新地址    begin -->
                            @if($count == 1)
                                <li class="add-add">
                                    <div class="add-box add-box-center">
                                        <a style="text-decoration: none;  position: absolute; top:30px; left:40%;"  onclick="addEditAddr( '/address_add?act=add_addr&id=  @if($data){{$data[0]['member_id']}}') @endif" >
                                            <i class="Hui-iconfont" style=" display: block; font-size: 18px;">&#xe604;</i>
                                            添加新地址
                                        </a>
                                    </div>
                                </li>
                            @endif
                            <!- ----添加新地址    end -->
                        </ul>
                    </div>
                </div>
            <!- ----配送方式    start -->
            </div>

            <div class="two_t">
               <h4>配送方式</h4>
            </div>
            <table border="0" class="car_tab" style="width:1110px; " cellspacing="0" cellpadding="0">
                <tr style="background-color: #fff;">
                    <td class="car_th" width="80"></td>
                    <td class="car_th" width="200">名称</td>
                    <td class="car_th" width="370">描述</td>
                    <td class="car_th" width="150">费用</td>
                </tr>
                @foreach($shiplist as $value)
                <tr style="background-color: #fff;">
                    <td align="center"><input type="radio" name="shipping"    @if($value->is_default ==1)checked @endif   class="shipping" value="{{$value->id}}" />
                    </td>
                    <td align="center" style="font-size:14px;"><b>{{$value->name}}</b></td>
                    <td>{{$value->desc}}</td>
                    <td align="center">{{$value->price}}</td>
                </tr>
                @endforeach
            </table>
            <!- ----配送方式    end -->
            <!- ----支付方式    start -->
            <div class="two_t">
                <h4>支付方式</h4>
            </div>
            <div class="two_t">
                <div style="border: 1px solid #ddd; background-color: #fff; ">
                    <div  style=" padding: 20px 50px;">

                       <span  >
                           <input type="checkbox" id="userbalance"  @if($user['paypwd'] !='' && $user['openbalance'] > 0)  @else disabled="disabled" @endif style="width:15px;height:15px;   "  >&nbsp;使用余额
                       </span>
                        <input type="text" maxlength="9" id="balance" oninput="onlyAmount(this);" autocomplete="off" value  style="width:100px; height:25px; border:1px solid #ddd; margin-left: 10px; padding: 0 10px; display: none">
                        <span>
                            (我的余额：
                            <b style="color:#ff4000;">{{$user['openbalance']}}</b>
                            元)
                        </span>
                        @if($user['paypwd'] =='')
                        <span id="setpaypwd" style="margin-left: 100px;  ">
                                为保障您的资金安全，请先
                                <a style=" color:#007cc3;">设置支付密码</a>
                        </span>
                        @endif
                        <br>
                        <br>
                        <p>
                            <span>
                               <input type="checkbox" id="userpoint"  @if($user['paypwd'] !='' && $user['point'] >= 100)  @else disabled="disabled" @endif  style="width:15px;height:15px;  "     >&nbsp;使用积分
                           </span>
                            <input type="text" maxlength="9" id="point" oninput="onlyNum(this);"  autocomplete="off" value  style="width:100px; height:25px; border:1px solid #ddd; margin-left: 10px; padding: 0 10px; display: none;">
                            <span>
                                (我的积分：
                                <b style="color:#ff4000;">{{$user['point']}}</b>
                                个,大于100个可使用 )
                            </span>
                        </p>
                    </div>
                </div>
                <div  class="two_t" style="padding: 30px 0px;  border:1px solid #ddd;background-color:#fff; ">
                    <ul class="pay">
                        <li >余额支付<div class="ch_img"></div></li>
                        <li>银行汇款/转账<div class="ch_img"></div></li>
                        <li>货到付款<div class="ch_img"></div></li>
                        <li   class="checked" >支付宝<input style="display: none;" name="pay_name"value="支付宝"><div class="ch_img"></div></li>
                    </ul>
                </div>
            </div>
            <!- ----优惠券    start -->
            <div class="two_t">
                <h4>使用优惠券(<em style="color:red;">2 </em>)
                    <i class=" ff  Hui-iconfont down " style=" cursor: pointer;">&#xe6d5;</i>
                    <input type="hidden" id="quan_sn" value="0"  >
                    <input type="hidden" id="parv" value="0"  >
                </h4>
                <div class="quan-list" style="  background-color: #fff; ">
                </div>
            </div>
            <!- ----优惠券    end -->
            <div class="two_t">
               <h4>结算信息</h4>
            </div>
            <table border="0" class="car_tab" style="width:1110px;background-color: #fff;" cellspacing="0" cellpadding="0">
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align: right; ">
                        <div style="width:100%;">
                            <span style=" display: inline-block;   width:100%; margin-top: 1px; ">
                                件商品 , 总计:<b  id="sum" style=" display: inline-block;  font-weight: bolder; color:#8f8f8f;  width:80px; text-align: right; color: #d62728;" >{{$amount}}
                            </b>
                            </span>
                            <span class="sp"   style=" display: inline-block;    width:100%;   margin-bottom: 20px; ">
                                 运费:<b id="shipPrice" style="display: inline-block;  font-weight: bolder; color:#8f8f8f;  color: #d62728;width:80px;" >12.00</b>
                            </span>
                            <span style=" display: inline-block;    width:100%;  margin-top: 16px; " >
                                 应付金额(元):<b id="sumPay" style="  font-size:20px;  color: #d62728;">{{$sumAndShip}}</b>
                            </span>

                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <td align="right" style="padding-right:0;"><b style="font-size:14px;">订单附言：</b></td>
                    <td style="padding-left:0;">
                        <textarea   name="message"  id="user_msg" class="user_msg" style="width:500px; height:50px;"></textarea>
                    </td>
                    <td align="right">
                        <p class="paypwd" style="display: none;">
                            <span>输入支付密码：</span>
                            <input  type="password" id="cbkpaypwd"  oninput="onlyNum(this)"   style="width:100px; height:25px; border:1px solid #ddd; margin-left: 10px; padding: 0 10px;">
                        </p>
                        <a class="topay"  id="topay" href="javascript:;">提交订单</a>
                        <span style="color:#007cc3 ;">
                            提交订单后尽快支付,商品才不会被别人抢走哦
                        </span>
                    </td>
                </tr>

            </table>
        </div>
    </div>
    <!--End 第二步：确认订单信息 End-->
    </form>
    <div id="edit-paypwd"  class="edit-paypwd" style="display: none;"  >
        <h4 style=" border-bottom:1px solid #bfbfbf; padding-bottom: 5px; ">
            设置支付密码
        </h4>
        <div style="padding-left:50px;">
            <p>
                <label>手机：</label>
                <input type="text" id="moble" readonly="readonly"  value="18205005604"  style="width:100px; border:none;" >
                <input type="button" value="获取验证码"  id="sendcode"  class="pwdbtn"  >
            </p>
            <p>
                <label>手机验证码：</label>
                <input type="text" id="code"  value  maxlength="6" autocomplete="off" placeholder="6位"  class="input" oninput="onlyNum(this)" >
            </p>
            <p>
                <label>设置支付密码：</label>
                <input type="password"  name="paypwd" style="display:none">
                <input type="password" id="paypwd"  value=""  maxlength="6" autocomplete="off"   class="input" oninput="onlyNum(this)" ><span class="tip">6位数字</span>
            </p>
            <p>
                <label>再输支付密码：</label>
                <input type="password" id="repaypwd"  value=""  maxlength="6" autocomplete="off"   class="input" oninput="onlyNum(this)" >
            </p>
            <p>
                <label></label>
                <input type="button" id=""  class="pwdbtn" value="提交"  onclick="editPaypwd();" >
            </p>
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

</body>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/home/js/menu.js"></script>
<script type="text/javascript" src="/home/js/lrscroll_1.js"></script>
<script type="text/javascript" src="/home/js/n_nav.js"></script>
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript">

    //添加地址+修改地址
    function addEditAddr(url){
        layer_show('',url,700,380);
    }

    function changeAddr(){
        $('.addr-list').show();
    }






    /**
     * 选择快递方式
     * @return[type][description]
     */
    $(function() {
        var enable = true;

        //收件地址选择
        $('.addr').click(function () {
            var addr = $(this).siblings('span').text();
            var cneeid = $(this).val();
            $('.addr-list').hide();
            $('.addr-default').text(addr);
            $('#cneeid').val(cneeid);
        });

        //配送方式选择
        $('.shipping').click(function(){
           var _shiping = $('.shipping');
           for(var i = 0; i < _shiping.length ; i++) {
               if(_shiping.eq(i).prop('checked')){
                   var url = '/home/order/getshipping';
                   var ship_id =_shiping.eq(i).val();
                   $.get(url,{'ship_id':ship_id},function(data){
                       if(data.status == 0){
                           $('#shipPrice').html(data.ship_price);
                           var t = $('input[name=selectQuan]:checked');
                           var parvalue = t.data('parvalue');
                           var sumpay = parseFloat($('#sum').text())+parseFloat(data.ship_price)-parseFloat(parvalue);
                           $('#sumPay').text(sumpay);
                       }

                   },'json');
               }

           }
        });

        //支付密码
        $("#setpaypwd a").click(function() {
            $("#edit-paypwd").slideDown(200);
        });

        //发送验证码
        $('#sendcode').click(function(){
            //time 过60秒才能再次点击发送
            if(enable == false){
                return ;
            }
            layer.msg('发送成功', { time:2000});
            enable =false;
            var num =60;
            var interval = window.setInterval(function(){
                $('#sendcode').val( '重新发送(' +(--num)+')');
                if(num == 0){
                    $('#sendcode').removeClass('ba_summary');
                    $('#sendcode').addClass('bk_important');
                    enable = true;
                    window.clearInterval(interval);
                    $('#sendcode').val('重新发送');
                }
            },1000);
            var v = $.trim($('#moble').val());
            $('#smscode').val('');//清除
            $.get('/service/reg' , {act:'send_sms',moble:v },function(data){
                if(data.status == 0){
                    //发送成功 //60秒内不能再发送验证码
                    //  layer.msg('发送成功', { time:2000});
                    return  true;
                }else {
                    return  false;
                }
            },'json');
        });

        //加载优惠券
        $('.ff').click(function(){
           var t = $('.ff');
            var good_ids='';
            var amount = parseFloat($('#sum').text());
            $(".cart-pdt").each(function() {
                good_ids += $(this).attr("id") + ",";
            });
            good_ids = good_ids.substring(0, good_ids.length - 1);

            if(t.hasClass('up')){
                //收起
                $('#parv').val(0);
                calcTotal();
                t.html('&#xe6d5;');
                t.removeClass('up').addClass('down');
                $(".quan-list").hide(500);
                return;
            }else if(t.hasClass('down')){
                //展开
                t.html('&#xe6d6;');
                t.removeClass('down').addClass('up');

                $.get('/service/order',{act:'get_myquan',amount:amount,good_ids:good_ids},function(res){
                    if(res.status == 0){
                        var html;
                        html='';
                        $.each(res.data, function(k, v) {
                            html += '  <p style="border-bottom: 1px dashed #ddd; color:#007cc3;">['+ v.name+'], 抵用金额 <span  style=" color:red; "   >'+      v.parvalue+'</span>元' ;
                            html += ' <input type="radio"  class="selectQuan"   data-parvalue="'+ v.parvalue + '" name="selectQuan"  onclick="selQuan(this);"  value=" ' + v.quan_sn  + ' "  >使用优惠券</p>';

                        });
                        $('.quan-list').html(html);
                    }else{
                        layer.msg(res.message, {time:2000});
                    }

                },'json');
                $(".quan-list").slideDown(500);
            }
        });




        //选中使用余额
        $('#userbalance').click(function(){
            inputdis();
            calcTotal();
            $('#balance').css('display',$(this).is(":checked") ? "inline-block" : "none"  )
        });

        //选中使用积分
        $('#userpoint').click(function(){
            inputdis();
            calcTotal();
            $('#point').css('display',$(this).is(":checked") ? "inline-block" : "none"  )
        });




        //提交订单
        $('#orderBtn').click(function(){
            $('#form-order').submit();
        });

        //提交订单
        $('#topay').click(function(){
            if( ($('#userbalance').is(':checked') || $('#userpoint').is(':checked')) && $.trim($("#cbkpaypwd").val()) == '') {
                layer.msg('请填写支付密码', {time:2000}); return ;
            }
            var shipid = 0;
            $("input[name='shipping']:checked").each(function() {
               shipid =  $("input[name='shipping']:checked").val();
            });



            var url = '/service/order';
            var data = {
                act :'add_order' ,
                cneeid: $('#cneeid').val(),    //地址id
                shipid: $("input[name='shipping']:checked").val(),  // 快递
                balance:$("#userbalance").is(":checked")? $.trim($("#balance").val()) :0 , //余额使用
                point:  $("#userpoint").is(":checked")? $.trim($("#point").val()) :0 ,     //积分使用
                parvalue: $.trim($("#parv").val()) , //余额使用
                quan_sn: $('#quan_sn').val(),
                paypwd:$.trim($("#cbkpaypwd").val()),
                user_msg:$('#user_msg').val(),   //订单附言
            };

            $.get(url,data,function(res){
                if(res.status == 0){

                }else{
                    layer.msg(res.message, {time:2000});
                }

            },'json');


        });

       });

    function onlyNum(t){
        t.value = t.value.replace(/[^\d]/g, '');//  /[^\d\.]/g
    }

    function onlyAmount(obj) {
        obj.value = obj.value.replace(/[^\d.]/g, "");  //清除“数字”和“.”以外的字符
        obj.value = obj.value.replace(/\.{2,}/g, "."); //只保留第一个. 清除多余的
        obj.value = obj.value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/, '$1$2.$3');//只能输入两个小数
        if (obj.value.indexOf(".") < 0 && obj.value != "") {//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
            obj.value = parseFloat(obj.value);
        }
    }

    function editPaypwd(){
        var moble = $.trim( $('#moble').val());
        var code = $.trim( $('#code').val());
        var paypwd = $.trim( $('#paypwd').val());
        var repaypwd = $.trim( $('#repaypwd').val());

        if(code.length<6){
            layer.msg('验证码位数不对', {time:2000});return;
        }
        if(paypwd == ''){
            layer.msg('请输入密码', {time:2000});return;
        }
        if(repaypwd == ''){
            layer.msg('请再输入密码', {time:2000});return;
        }
        if(paypwd !== repaypwd) {
            layer.msg('两次输入的密码不一致', {time:2000});return;
        }
        $.get( '/service/user',{act:'set_paypwd',moble:moble,code:code,paypwd:paypwd,repaypwd:repaypwd},function(res){
            if(res.status == 0){
                layer.msg('设置成功', {time:2000});
                $("#edit-paypwd,setpaypwd").remove();
                $("#userbalance,#userpoint").removeAttr("disabled");
            }
        },'json')

    }

    //勾选余额，或者积分支付时，显示输入支付密码
    function inputdis(){
        if($("#userbalance").is(":checked") ||$("#userpoint").is(":checked")){
            $('.paypwd').show();
        }else{
            $('.paypwd').hide();
        }
    }



    var goods_amount = parseFloat({{$amount}});
    var pointpay = 100;
    var mostpoint =50;
    //计算订单金额   使用顺序 积分>余额
    function calcTotal(){
        var sum = 0;
        var shipPrice =  parseFloat($('#shipPrice').html()); //快递费用
        var payAmount = goods_amount + shipPrice ; //应付金额
        var point_use =0; //使用积分
        var point = parseFloat($("#point").siblings().children("b").html()); //现有积分
        var balance_use =0; //使用余额
        var balance = parseFloat($("#balance").siblings().children("b").html()); //现有余额
        var point_amount = 0; //积分抵用的金额
        var balance_amount = 0; //余额支付的金额
        var parvalue = parseFloat($('#parv').val()); //优惠券抵用的金额

        //扣除 优惠券 抵用金额  优惠券优先
        payAmount = payAmount-parvalue;

        //积分
        if($('#userpoint').is(':checked')){
            point_amount = parseInt( payAmount * mostpoint *0.01 );//
            point_use = point_amount * pointpay;
            if(point_use > point){
                point_use = point - point % pointpay;
                point_amount = point_use/pointpay;
            }
            point_amount = point_amount.toFixed(2);
            payAmount = payAmount - point_amount;
            $('#point').val(point_use);
        }else{
            $('#point').val('');
        }

        //余额
        if($('#userbalance').is(':checked')){
            balance_use =  payAmount > balance ?  balance: payAmount;//使用余额
            payAmount = payAmount - balance_use;
            $('#balance').val(balance_use);
        }else{
            $('#balance').val('');
        }
   // <span style=" display: inline-block;    width:100%;  margin-top: 16px; " >
   //         应付金额(元):<b id="sumPay" style="  font-size:20px; color:#ff4e00;">{{$sumAndShip}}</b>
   //         </span>


        if(parvalue !=0){
            $('.parv_sli').remove();
            if ($("#parv-offset").length==0) {
                $(".sp").after('<span class="parv_sli"  style="  display: inline-block; color:#007cc3; border-bottom: 1px dashed #ddd;  width:100%; ">优惠券抵用￥：<b id="parv-offset" style="display: inline-block;   width:80px;">-' + parvalue + '</b></span>');
            }else{

            }
        }else{
            $('.parv_sli').remove();
        }

        //
        if($('#userpoint').is(':checked')){
            if ($("#point-offset").length==0) {
                $(".sp").after('<span class="point_sli" style="   display: inline-block; color:#007cc3; border-bottom: 1px dashed #ddd; width:100%;">积分抵用：<b id="point-offset"  style="display: inline-block;   width:80px;">-' + point_amount + '</b></span>');
            }else{

            }
        }else{
            $('.point_sli').remove();
        }
        if($('#userbalance').is(':checked')){
            if ($("#balance-offset").length==0) {
                $(".sp").after('<span class="balance_sli"  style=" display: inline-block;color:#007cc3; border-bottom: 1px dashed #ddd;  width:100%;">余额支付：<b id="balance-offset" style="display: inline-block;   width:80px; ">-' + balance_use + '</b></span>');
            }else{

            }
        }else{
            $('.balance_sli').remove();
        }


        $('#sumPay').html(payAmount);

    }

    //选择要使用的优惠券
    function selQuan(t){
        var sn = $('input[name=selectQuan]:checked').val();
        var parvalue = parseFloat( $(t).data('parvalue') );
        $('#quan_sn').val(sn);
        $('#parv').val(parvalue);
        calcTotal();
    }
</script>

</html>
