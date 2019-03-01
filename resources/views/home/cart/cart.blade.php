<!DOCTYPE html >
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />

    <script type="text/javascript" src="/home/js/num.js">
        var jq = jQuery.noConflict();
    </script>

    <script type="text/javascript" src="/home/js/shade.js"></script>

    <title>购物车</title>
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
        }
        .topay:link{
            cursor: pointer;
            color: #fff;
        }
        .topay:hover{
            color: #fff;
        }


    </style>
</head>
<body>
<!--Begin Header Begin-->
<div class="soubg" style=" height:100px;border-bottom: 1px solid #eee;">
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
<div class="i_bg">
    <!--Begin 第一步：查看购物车 Begin -->
    <div class="content mar_20" >
        <div class="cart-step">
            <ul>
                <li  class="cart1"> <i></i>购物车 </li>
                <li  class="cart2 "> <i></i>确认订单 </li>
                <li  class="cart3"> <i></i>付款</li>
                <li  class="cart4"> <i></i>支付成功</li>
            </ul>
        </div>
        <div>
        <table border="0" class="car_tab" style="width:1200px; margin-bottom:50px;" cellspacing="0" cellpadding="0">
            <thead>
            <tr style=" height:40px;  border-bottom: 1px solid #eee;  ">
                <th width="100"><input type="checkbox" name="ck_ all"  id="ck_all" onclick="checkAll(this,'#list' );">全选</th>
                <th class="car_th" width="">商品名称</th>
                <th class="car_th" width="250">配置</th>
                <th class="car_th" width="130">单价(元)</th>
                <th class="car_th" width="150">购买数量</th>
                <th class="car_th" width="130">小计(元)</th>
                <th class="car_th" width="150">操作</th>
            </tr>
            </thead>
            <tbody id="list">
            @foreach($cartList['products'] as $value)
            <tr  id="{{$value['cart_pdt']['id']}}"   data-spec="{{$value['cart_pdt']['spec']}}">
                <td width="15">
                    <input type="checkbox" name="ck_list" id="ck_list"  @if(isset($value['is_checked'])&& $value['is_checked']==1) checked @endif value="{{$value['cart_pdt']['id']}}" >
                </td>
                <td>
                    <div class="c_s_img" style="text-align: center ; vertical-align: middle;"><img src="{{url($value['cart_pdt']['preview'])}}" width="73" height="73" /></div>
                    {{$value['cart_pdt']['name']}}
                </td>
                <td align="center">
                    @if(isset($value['cart_pdt']['spec_name']) )
                        @foreach($value['cart_pdt']['spec_name'] as $v)
                            <span style="font-size: 8px;">[ {{$v}}] </span><br>
                        @endforeach
                    @endif
                </td>
                <td align="center" >￥：<span id="price" class="price" >{{$value['cart_pdt']['price'] }}</span>&nbsp;
                </td>
                <td align="center">
                    <div class="c_num">
                        <input type="button" value=""   class="car_btn_1 reduce" />
                        <input type="text" value="{{$value['count']}}" data-max="{{$value['cart_pdt']['num']}}"   class="car_ipt result"/>
                        <input type="button" value="" class="car_btn_2 add"  id="add"/>
                    </div>
                </td>
                <td align="center" style="color:#ff4e00;">￥：<span id="subtotal" class="subtotal">{{$value['cart_pdt']['price'] * $value['count']}}</span>&nbsp;
                </td>
                <td align="center">
                    <a href="javascript:;" class="addfav"
                       @if((isset($value['myfav']) && $value['myfav']!= 0) || !isset($value['myfav']))
                       onclick="addFav(this,{{$value['cart_pdt']['id']}});"
                            @endif  >
                        @if(isset($value['myfav']) && $value['myfav'] == 1)已收藏 @else 加入收藏  @endif</a><br>
                    </bt><a href="javascript:;"  class="removeproducts"  onclick="removeGoods('{{$value['cart_pdt']['id']}}',
                    '{{$value['cart_pdt']['spec']}}');"  >删除</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        <div style=" border:1px solid #eee; background-color: #fff; width:99%; height:80px;  line-height: 90px;">
            <div style=" width:85%;float: left; margin-left: 20px;">
                <label ><input type="checkbox" name="ck_ all"  id="ck_all" onclick="checkAll(this,'#list' );">全选 &nbsp;&nbsp;&nbsp;</label> <a href="javascript:;" class ="removebatch">删除选中产品</a>
                <div style="float: right;">
                    <span >已选商品：<b  class="count" id="count"  style="font-size:22px; color:#ff4e00;">{{$cartList['count']}}</b>件&nbsp;&nbsp;</span>
                     <span >商品总价：<b  class="amount" id="amount"  style="font-size:22px; color:#ff4e00;">￥{{$cartList['amount']}}</b></span>
                </div>
            </div>
            <div style=" float: right; margin-top: 15px; margin-right: 20px;">
                <a class="topay" href="JavaScript:;"> 去结算</a>

            </div>

        </div>
    </div>
    <!--End 第一步：查看购物车 End-->



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

    //进入页面时默认选中购物车中所有产品
    window.onload =function(){
        $(list).find("input[type='checkbox']").each(function () {
            var p = $(this).parents('tr');
            var checked = $(this).prop('checked');
            if(checked){
                p.css("background-color","#fff4e0")
            }else{
                p.css("background-color","#fff")
            }
            sumShopping();
        })
    }


    $(function(){
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
            var price =(p.prev().children('.price').html()) ;
            var total =(n* price).toFixed(2);
            updateCart(p.parent().attr("id"), p.parent().data("spec"), n);
            p.next().children('.subtotal').html(total);
            sumShopping();

        });
        //批量删除购物车中选中的产品
        $('.removebatch').click(function(){
            var ids='';
            var spec='';
            $("#list input[name='ck_list']:checked").each(function() {
              ids += $(this).parents('tr').attr('id')+'@';
              spec += $(this).parents('tr').data('spec')+'@';
            });
            if(ids == ''){
                layer.msg('勾选需要删除的商品', {time:2000});
                return ;
            }
            ids = ids.substring(0, ids.length - 1);//去掉最后面的@
            layer.confirm('确定要删除吗?',function(index){
                removeGoods(ids,spec);
            });
        });


        $('.topay').click(function(){
            //购物车中有勾选的才能 提交
            if( $("#list input[name='ck_list']:checked").length > 0  ){

                $.get('/service/cart' ,{act:'to_order'},function (res) {
                   if(res.status == 0){
                       location.href= res.data.url;

                   }else{
                       layer.msg(res.message, {time:2000});
                   }

                },'json')
            }else{
                layer.msg('请选择需要购买的商品', {time:2000});
            }
        });

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
            layer.msg('抱歉仓库只有'+n+'件', {time:2000});
        }
        if(n < 1){
            n = 1;
        }
        txtNum.val(n);
    }
    //全选
    function checkAll(obj,list){
        var checked =$(obj).prop('checked');
        $('#ck_all').prop('checked',checked);
        $(list).find("input[type='checkbox']").each(function () {
            $(this).prop('checked',checked);
            updateStatus($(this));
        })
    }

    //更新商品选择状态
    $("#list input[name='ck_list'] ").each(function () {

        $(this).click(function () {
            updateStatus($(this));

        });
    });

    //  更新购物车商品状态
    function updateStatus(t){
        var p = t.parents('tr');
        var checked = t.prop('checked');
        var id = p.attr('id'),
            spec = p.data('spec'),
            status = checked==true ? 1:0;

        $.get('/service/cart',{ act:'get_cart_status',gid:id,spec:spec,status:status},function(res){
            if(res.status != 0){
                layer.msg(res.message, {time:2000});
            }
        },'json');

        if(checked){
           p.css("background-color","#fff4e0")
        }else{
           p.css("background-color","#fff")
       }
        //更新商品count 和 amount
        sumShopping();
    }


    function updateCart(id ,spec , num){
        $.get('service/cart',{ act:'add_cart',gid:id,num:num,spec:spec,type:1},function (res) {
            if(res.status == 0){


            }
        },'json');


    }
    function sumShopping(){
        var n = 0, p = 0;
        if( $("#list input[name='ck_list']").length > 0  ){
            $("#list input[name='ck_list']:checked").each(function(){
                n += parseFloat($(this).parents('tr').find(".result").val());//计算总件数count
                p += parseFloat($(this).parents('tr').find(".subtotal").html());//计算总金额amount
            });
        }else{

        }

        $('.count').html(n);
        $('.amount').html(p.toFixed(2));
    }


    //添加收藏
    function addFav(obj,id){
        var t =$(obj);
        var act = 'add_fav';
        $.get('/service/user' ,{ act:act,gid:id} ,function (data) {
            if(data.status == 0){
                    layer.msg('收藏成功', {time:2000});
                    t.html('已收藏');
                    t.removeAttr('onclick');

            }else if(data.status == 20){
                layer.msg('请先登陆', {time:2000});
                //  setTimeout("window.location.href='/login' ", 2000);
            }else{
                layer.msg(data.message, {time:2000});
            }

        } ,'json');
    }

    //购物车移除商品
    function removeGoods(id,spec) {
        $.get('/service/cart',{act:'remove_products',gid:id,spec:spec},function(res){
            if(res.status ==0){
                layer.msg('移除成功', {time:2000});
                $('.cartinfo').html(res.count);
                var list = id.split("@");
                $.each(list, function(k, v) {
                    $("#" + v).remove();
                });
                sumShopping();
            }

        },'json');
    }
</script>

</html>
