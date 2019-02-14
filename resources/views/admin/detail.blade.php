@extends('admin.master')

<style>

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
</style>
@section('content')

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe687;</i> 订单 <span class="c-gray en">/</span> <a href="{{url('admin/order')}}">订单列表</a> <span class="c-gray en">/</span> 订单详情 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">

    <div class="cl pd-5  bk-gray mt-20">
        <span class="l">
            订单号：{{$orderData['order_sn']}} &nbsp; <b class ="c-red">{{$orderData['status_name']}}</b>
        </span>
        <span class="r" style="margin-right: 20%; ">
            <button  onClick="" class="btn btn-default radius "   type="reset">&nbsp;&nbsp;付款&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius "  type="reset">&nbsp;&nbsp;发货&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius " type="reset">&nbsp;&nbsp;取消订单&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius " type="reset">&nbsp;&nbsp;打印快递单&nbsp;&nbsp;</button>

        </span>
    </div>
<!---<br>------------------------------------------------>


    <div class="panel panel-default" style="width: 45%; float: left; margin-top: 30px;">
        <div class="panel-header">订单详情</div>
        <div class="panel-body">面板内容</div>
    </div>

    <div class="panel panel-default" style="width: 45%; float: right;margin-top: 30px;">
        <div class="panel-header">收件人信息</div>
        <div class="panel-body">姓名：<input type="text"  class="input-mi"  style=" text-align: center; width:100px;" onchange=""  value=" {{$orderData['consignee'] }}" ></div>
        <div class="panel-body">电话：<input type="text"  class="input-mi"  style=" text-align: center; width:200px;" onchange=""  value="{{$orderData['moble'] }}" ></div>
        <div class="panel-body">
            地区：
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
        <div class="panel-body"></div>
        <div class="panel-body">地址：</div>
        <div class="panel-body">邮编：</div>
    </div>

    <div class="panel panel-default" style="width: 45%; float: left;margin-top: 30px;">
        <div class="panel-header"></div>
        <div class="panel-body">面板内容</div>
    </div>
    <div class="panel panel-default" style="width:45%; float: right;margin-top: 30px;">iu
        <div class="panel-header">面板标题</div>
        <div class="panel-body">面板内容</div>
    </div>


<!---------------------------------------------------->
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div class="cl pd-5  bk-gray mt-20">
        <span class="l">
            订单号：{{$orderData['order_sn']}} &nbsp; <b class ="c-red">{{$orderData['status_name']}}</b>
        </span>
        <span class="r" style="margin-right: 20%; ">
            <button  onClick="" class="btn btn-default radius "   type="reset">&nbsp;&nbsp;付款&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius "  type="reset">&nbsp;&nbsp;发货&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius " type="reset">&nbsp;&nbsp;取消订单&nbsp;&nbsp;</button>
            <button  onClick="" class="btn btn-success radius " type="reset">&nbsp;&nbsp;打印快递单&nbsp;&nbsp;</button>

        </span>
    </div>

    <table class="table table-border table-bordered table-bg" style=" text-align: left;">
        <thead>
        <tr>
            <th scope="col" colspan="4">订单详情</th>
        </tr>
        </thead>
        <tbody>
        <tr >
            <td>订单金额: {{$orderData['order_amount']}} </td>
            <td>未付金额: {{$orderData['order_sn']}} </td>
            <td>商品总额: {{$orderData['products_amount']}} </td>
            <td>运费: {{$orderData['shipping_fee']}} </td>
        </tr>
        <tr >
            <td>使用余额: </td>
            <td>积分抵用:  </td>
            <td>优惠券抵用: </td>
            <td>返现: </td>
        </tr>
        <tr>
            <td scope="col" colspan="4" style=" height: 30px;"> </td>
        </tr>
        <tr >
            <td>下单时间:  {{ date('Y-m-d H:i:s',$orderData['add_time'] ) }}</td>
            <td>会员账号：{{$orderData['nickname']}}</td>
            <td>订单来源：全平台  2222</td>
            <td>收货时间：</td>
        </tr>
        <tr >
            <td>支付状态： @if($orderData['pay_status']) 已支付 @else 未支付 @endif</td>
            <td>支付方式：微信小程序支付</td>
            <td>支付时间：</td>
            <td>支付交易号：</td>
        </tr>
        <tr >shipping_status
            <td>发货状态：{{$orderData['shipping_status']}}</td>
            <td>发货方式：商家配送</td>
            <td>发货时间：</td>
            <td>发货单号：<input type="text"  class="input-mi"  style=" text-align: center; width:100px;" onchange=""  value="" ></td>    </td>
        </tr>
        <tr >
            <td colspan="2">发票抬头：</td>
            <td  colspan="2">发票内容：</td>
        </tr>
        <tr>
            <td scope="col" colspan="4" style=" height: 30px;">会员留言：{{$orderData['message']}} </td>
        </tr>
        </tbody>
    </table>
    <br>

    <table class="table table-border table-bordered table-bg" style=" text-align: left;">
        <thead>
        <tr>
            <th scope="col" colspan="4">收货人信息</th>
        </tr>
        </thead>
        <tbody>
        <tr >
            <td>收货人：<input type="text"  class="input-mi"  style=" text-align: center; width:100px;" onchange=""  value=" {{$orderData['consignee'] }}" ></td>
            <td>手机号码：<input type="text"  class="input-mi"  style=" text-align: center; width:200px;" onchange=""  value="{{$orderData['moble'] }}" ></td>
            <td colspan="2" style="width:60%;">
                地址：
                <span class="select-box inline"  data-toggle="tooltip" data-placement="bottom" >
		            <select class="select" name="category_id" size="1">
                        <option value="0">省份</option>
                        <option value="0">所有分类</option>
                    </select>
                </span>
                <span class="select-box inline"  data-toggle="tooltip" data-placement="bottom" >
                    <select class="select" name="category_id" size="1">
                         <option value="0">城市</option>
                        <option value="0">所有分类</option>
                    </select>
		        </span>
                <br>
                详细地址：<input type="text"  class="input-mi"  style=" text-align: center; width:60%; margin-top: 4px;" onchange=""  value="{{$orderData['address'] }}" ></td>
        </tr>

        </tbody>
    </table>
    <br>
    <br>

    <table class="table table-border table-bordered table-bg" style=" text-align: left;">
        <thead>
        <tr>
            <th scope="col" colspan="5">商品信息</th>
        </tr>
        </thead>
        <tbody>
        <tr >
           <td>商品信息 </td>
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
            <td>{{ $pdt['buy_number'] }}</td>
            <td>{{ $pdt['product_price'] }}</td>
            <td>{{ $pdt['product_price'] * $pdt['buy_number']}}</td>
            <td>{{$orderData['shipping_status']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
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


    </script>

@endsection