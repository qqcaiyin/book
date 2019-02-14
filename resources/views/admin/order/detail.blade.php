@extends('admin.master')

<style>

    span{
        font-weight: bolder;
    }
    a:hover{
        text-decoration: none;
    }
    .input-mi{
        border: 1px solid #ddd;

        cursor: pointer;
        text-align: center;
        width:300px;
        height:30px;
        text-align:left;
        display:inline;
        border-radius:5px;
    }
    .input-mi:focus{
        box-shadow: 0 0 15px  black;
    }
    .input-mi:hover{
    // background-color: red;
        border: #bbb 1px solid;
    }
    .jin{
        opacity:0.8;
        pointer-events:none;
    }
</style>
@section('content')

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe687;</i> 订单 <span class="c-gray en">/</span> <a href="{{url('admin/order')}}">订单列表</a> <span class="c-gray en">/</span> 订单详情 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">

    <div class="cl pd-5  bk-gray mt-20" style="border: 0px;">

        <span class="l" style="width:70%; ">
            <button  onClick="" class="btn btn-success radius   " id="pay"  type="reset">&nbsp;&nbsp;付款&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius  " id="ship" type="reset">&nbsp;&nbsp;发货&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius  " id="cal"  type="reset">&nbsp;&nbsp;取消订单&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius  " id="ptr"  type="reset">&nbsp;&nbsp;打印快递单&nbsp;&nbsp;</button>

        </span>
        <span class="r" style="margin-right: 20px; ">

            <button  onClick="" class="btn  radius " style=" opacity:0.8;pointer-events:none;  " > 状态：<sapn class="c-red" >{{$orderData['status_name']}}&nbsp;</sapn>&nbsp;</button>
            <input type="hidden" id="status" value="{{$orderData['status']}}">
        </span>
    </div>
<!---<br>------------------------------------------------>
    <div class="panel panel-default" style="width: 100%; float: left; margin-top: 30px;">
        <div class="panel-header">商品信息</div>
        <div class="panel-body"> <table class="table table-border  table-bg" style=" text-align: left;">
                <tbody>
                <tr >
                    <td> </td>
                    <td> </td>
                    <td>数量</td>
                    <td>单价</td>
                    <td>金额</td>
                    <td>配送状态</td>
                </tr>
                @foreach($orderData['pdt'] as $pdt)
                    <tr >
                        <td>
                            <div   class="item" >
                                <a href="#" target="_blank" class="img">
                                    <img  width="60" height="60" src="{{url($pdt['preview'])}}"></a>
                                <a href="https://demo.yunec.cn/qfnhe-g.html" target="_blank" class="txt" >
                                    <span>{{ $pdt['product_name']  }} </span>
                                </a>
                            </div>
                        </td>
                        <td>@if($pdt['product_attr'])<span >规格：</span>{{ $pdt['product_attr'] }} @endif</td>
                        <td>{{ $pdt['buy_number'] }}</td>
                        <td>{{ $pdt['product_price'] }}</td>
                        <td>{{ $pdt['product_price'] * $pdt['buy_number']}}</td>
                        <td>{{$orderData['shipping_status']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="panel panel-default" style="width: 48%; float: left; margin-top: 30px;">
        <div class="panel-header">订单金额明细</div>
        <div class="panel-body"><span>商品总额: </span>{{$orderData['products_amount']}}</div>
        <div class="panel-body"><span>运费: </span>{{$orderData['shipping_fee']}}</div>
        <div class="panel-body"><span>使用余额:</span></div>
        <div class="panel-body"><span>积分抵用:</span></div>
        <div class="panel-body"><span>优惠券抵用:</span></div>
        <div class="panel-body"><span>返现:</span></div>
        <div class="panel-body"><span>订单金额: </span>{{$orderData['order_amount']}}</div>
        <div class="panel-body"><span>已支付金额: </span></div>

    </div>

    <div class="panel panel-default" style="width: 48%; float: right;margin-top: 30px;">
        <div class="panel-header">收件人信息</div>
        <div class="panel-body"><span>姓名：</span><input type="text"  class="input-mi"  style=" text-align: center; width:100px;" onchange=""  value=" {{$orderData['consignee'] }}" ></div>
        <div class="panel-body"><span>电话：</span><input type="text"  class="input-mi"  style=" text-align: center; width:200px;" onchange=""  value="{{$orderData['moble'] }}" ></div>
        <div class="panel-body">
            <span> 地区：</span>
            <span class="select-box inline"  data-toggle="tooltip" data-placement="bottom" >
                <select class="select" name="category_id" size="1">
                    <option value="0">省份</option>
                    <option value="0">所有分类</option>
                </select>
            </span>
            -
            <span class="select-box inline"  data-toggle="tooltip" data-placement="bottom" >
                <select class="select" name="category_id" size="1">
                    <option value="0">城市</option>
                    <option value="0">所有分类</option>
                </select>
            </span>
        </div>
        <div class="panel-body"><span>地址：</span><input type="text"  class="input-mi"  style=" text-align: center; width:60%; margin-top: 4px;" onchange=""  value="{{$orderData['address'] }}" ></div>
        <div class="panel-body"><span>邮编：</span><input type="text"  class="input-mi"  style=" text-align: center; width:100px;" onchange=""  value=" {{$orderData['zipcode'] }}" ></div>
    </div>
    <br>

    <div class="panel panel-default" style="width: 55%;float: left;  margin-top: 30px;">
        <div class="panel-header">订单信息</div>
        <div class="panel-body"><span>订单号:</span> {{$orderData['order_sn']}}</div>
        <div class="panel-body"><span>当前状态:</span> {{$orderData['shipping_fee']}}</div>
        <div class="panel-body"><span>支付状态:</span></div>
        <div class="panel-body"><span>配送状态:</span></div>
        <div class="panel-body"><span>订单类型:</span></div>
        <div class="panel-body"><span>订单附言: </span>{{$orderData['message']}} </div>
    </div>
    <div class="panel panel-default" style="width: 40%;float: right;  margin-top: 30px;">
        <div class="panel-header">发票</div>
        <div class="panel-body"><span>发票抬头: </span>{{$orderData['order_sn']}}</div>
        <div class="panel-body"><span>发票内容: </span>{{$orderData['shipping_fee']}}</div>
    </div>
    <div class="panel panel-default" style="width: 40%;float: right;  margin-top: 30px;">
        <div class="panel-header">买家信息</div>
        <div class="panel-body"><span>用户名:</span> {{$orderData['nickname']}}</div>
        <div class="panel-body"><span>电话: </span>{{$orderData['member_phone']}}</div>
        <div class="panel-body"><span>Email:</span> {{$orderData['member_email']}}</div>
    </div>
    <div class="panel panel-default" style="width: 40%;float: left;  margin-top: 30px;">
        <div class="panel-header">配送信息</div>
        <div class="panel-body"><span>配送方式: </span>{{$orderData['shipping_name']}}</div>
        <div class="panel-body"><span>快递单号:</span> 3334433</div>
        <div class="panel-body"><span>重量: </span>{{$orderData['shipping_fee']}}</div>
        <div class="panel-body"><span>配送跟踪:</span> </div>
    </div>

</div>

@endsection

@section('my-js')

    <script type="text/javascript">

        function member_add(title,url,id,width,height){

            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        function member_show(title,url,width,height){
            layer_show(title,url,width,height);
        }

        function change_money(title,url,width,height) {
            layer_show(title,url,width,height);
        }

        function  order_cancel(obj,sn){
            layer.confirm('确认要取消订单吗？',function (index) {
                var url = '/admin/service/order/cancel'
                $.get(url,{'order_sn':sn},function(data){
                    console.log(data);
                    if(data.status == 0){
                        layer.msg(data.message, {icon:1, time:2000});
                        location.replace(location.href);
                    }
                    console.log(data);

                },'json');

            });
        }

        //刷新页面显示一次
        window.onload = function() {
           var status = $('#status').val();
           //订单支付超时
           if(status == 1 ||status == 2 || status == 5 ||status == 6 ||status == 8){
               $('#pay').removeClass('btn-success').addClass('jin btn-default');
               $('#ship').removeClass('btn-success').addClass('jin btn-default');
               $('#cal').removeClass('btn-success').addClass('jin btn-default');
               $('#ptr').removeClass('btn-success').addClass('jin btn-default');
           }
            //待支付
            if(status == 0){
                $('#ship').removeClass('btn-success').addClass('jin btn-default');
                $('#cal').removeClass('btn-success').addClass('jin btn-default');
                $('#ptr').removeClass('btn-success').addClass('jin btn-default');
            }
            //待发货
            if(status == 4){
                $('#pay').removeClass('btn-success').addClass('jin btn-default');
            }
        };


    </script>

@endsection