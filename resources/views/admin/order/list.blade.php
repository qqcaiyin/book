@extends('admin.master')

@section('content')
    <style>

        .table1 tr{
            border-collapse: collapse;
            border:1px solid #e2e2e2;
        }
        .table1 ,td{
            border:0px;
        }
        .opbtn{
            float: right;
            text-align: center;
            display: inline;

        }
        div{
            display: block;
        }
        .opbtn a{
            width:70px;
            display: inline-block;
            margin-bottom: 5px;
            margin: 5px 10px;
            padding: 2px 10px;
            text-align: center;
            border:1px solid #ed8a47;
        }
        .opbtn a:hover{
            text-decoration:none;
        }
        .glist{
            width:30%;
            float:left;
            padding-left: 5px;

        }
        .item{
            float: left;
            width: 100%;
            margin-left: 25px;
            position: relative;
            padding-top: 3px;
            padding-bottom: 3px;
        }
        .item .img{
            width:60px;
            float:left;
        }

        .olist{
            width: 68%;
            float:right;

        }
        .cnee{
            float: left;
            width: 50%;
            display: block;
            margin-left: 30px;

        }
        .detail{
            float: left;
            width:100%;
            border: 1px solid #fff;
        }
        .detail:hover{
            border: 1px solid red;
        }

    </style>

<nav class="breadcrumb"><i class="Hui-iconfont">&#xe687;</i> 订单 <span class="c-gray en">/</span> 订单管理 <span class="c-gray en">/</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">

    <div class="cl pd-5  " >
        <span class="l">
            <a class="btn btn-primary radius" href="{{url('admin/order_add')}}"><i class="Hui-iconfont">&#xe604;</i> 添加订单</a>
         <a class="btn btn-primary radius" onclick="checkbox_del(' > 删除','')" href="javascript:;"><i class="Hui-iconfont">&#xe60b;</i>批量删除</a>
            <a class="btn btn-primary radius" href="{{ url('') }}"><i class="Hui-iconfont">&#xe609;</i>回收站</a>
        </span>

        <form method="get" action=""  >
{{csrf_field()}}
            <div class="text-c" align="right" style="float:  right;">
                <input type="text" placeholder="订单号"  class="input-text ac_input" name="order_sn" value="@if(!empty($search)){{$search['order_sn']}} @endif" id="search_text" style="width:150px">
                <input type="text" placeholder="会员名"  class="input-text ac_input" name="nickname" value="@if(!empty($search)){{$search['nickname']}}   @endif" id="search_text" style="width:150px">
                <label >状态</label>
                <span class="select-box inline" style=" width:100px;"data-toggle="tooltip" data-placement="bottom" title="">
		        <select class="select" name="search_tp2" size="1">
                    <option value="10">所有</option>
                   <option value="0" @if(!empty($search['search_tp2'])&&$search['search_tp2'] == 1) selected @endif>待支付</option>
                     <option value="4" @if(!empty($search['search_tp2'])&&$search['search_tp2'] == 4) selected @endif>等待发货</option>
                    <option value="5" @if(!empty($search['search_tp2'])&&$search['search_tp2'] == 5) selected @endif>待收货</option>
                    <option value="7" @if(!empty($search['search_tp2'])&&$search['search_tp2'] == 7) selected @endif>已退款</option>
                    <option value="2" @if(!empty($search['search_tp2'])&&$search['search_tp2'] == 2) selected @endif>已取消</option>
                   <option value="3" @if(!empty($search['search_tp2'])&&$search['search_tp2'] == 3) selected @endif>已删除</option>
                </select>
		    </span>
                <label >日期 </label>
                <input type="text"  autocomplete="off"      onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate"  name=" starttime"  style="width:120px;"  value="@if(!empty($balance_logs->ser)){{$balance_logs->ser['starttime']}}  @endif">
                -
                <input type="text"  autocomplete="off"  name="endtime"onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:120px;"  value="@if(!empty($balance_logs->ser)){{$balance_logs->ser['endtime']}}  @endif">

                <input type="text"  style="display: none" name="is_search" value="1">
                <input type="text" placeholder="关键词"  class="input-text ac_input" name="keywords"
                       value=""
                       id="search_text" autocomplete="off" style="width:100px">
                <input  type="submit" class="btn btn-default"  value="搜索">
            </div>
        </form>
    </div>
        <div class="mt-20">
            <table class="table  table-hover table-bg table1 " >
                <thead>
                <tr class="text-c">
                    <th width="15"><input type="checkbox" name="" value=""></th>
                    <th width="10%">订单号</th>
                    <th width="8%">状态</th>
                    <th width="10%">会员</th>
                    <th width="10%">订单金额</th>
                    <th width="10%">商品金额</th>
                    <th width="10%">待支付金额</th>
                    <th width="">下单时间</th>
                    <th width="10%">操作/打印</th>
                </tr>
                </thead>
                <tbody>
                @if($orderData != null)
                @foreach($orderData as $order)
                <tr class="text-c">
                    <td><input type="checkbox" value="1" name=""></td>
                    <td>{{$order->order_sn}}</td>
                    <td>

                        <span   style=" color: #d3a60c;" >
                            {{$order->status_name}}
                        </span>

                    </td>
                    <td>{{$order->nickname}}</td>
                    <td>{{$order->order_amount}}</td>
                    <td>{{$order->products_amount}}</td>
                    <td class="td-status1">
                        @if($order->status >= 4)
                            0.00
                        @else
                        {{$order->order_amount-$order->money_paid}}
                        @endif
                    </td>
                    <td class="td-status">
                        {{date('Y-m-d h:i:s',$order->add_time)}}
                    </td>
                    <td><a href="{{url('/admin/order/print')}}" target="_blank" ><span class="label label-success radius" style = " background-color: #f9a123"  >购</span></a></td>
                </tr>
                    <tr ><td colspan="9">
                            <div  class="detail"  >
                                <div  class="glist">
                                @foreach($order->pdt as $pdt)
                                    <div   class="item" >
                                        <a href="#" target="_blank" class="img">
                                            <img  width="60" height="60" src="{{url($pdt['preview'])}}"></a>
                                        <a href="https://demo.yunec.cn/qfnhe-g.html" target="_blank" class="txt" >
                                            <span>￥{{ $pdt['product_price']  }} x  {{$pdt['buy_number']    }}</span> <br>
                                            @if($pdt['product_attr'])<span >{{ $pdt['product_attr'] }}</span> <br> @endif
                                            <span>{{ $pdt['product_name']  }} </span>
                                        </a>
                                    </div>
                                @endforeach
                                </div>
                                <div class="olist">
                                    <div  class="cnee"  >
                                        <span>{{$order->consignee}}</span><br>
                                        <span>{{$order->moble}}</span><br>
                                        <span>{{$order->province}}{{$order->city}}{{$order->address}}</span><br>

                                    </div>
                                    <div   class="opbtn"    >
                                        @if($order->status ==4)
                                        <a href="javascript:void(0);" onclick="javascript:edit('./admin.html?do=delivery&amp;ids=19011555525755');">发货</a><br>@endif
                                        @if(($order->status == 0) || ($order->status == 4)   )
                                        <a href="javascript:void(0);" data-act="cancel" onclick="order_cancel(this,{{$order->order_sn}});">取消订单</a><br>@endif
                                        @if($order->status == 4)
                                        <a href="admin.html?do=order.printexpress&amp;ids=19011555525755" target="_blank">打印快递单</a><br>@endif
                                        <a href="/admin/order/info? do=details&amp;id={{$order->order_sn}}">详情</a><br>
                                        <a href="javascript:void(0);" onclick="isdel(this,{{$order->order_sn}});">删除</a><br>
                                    </div>
                                </div>
                            </div>
                    </tr>

                 @endforeach
                 @else
                    <tr><td colspan=" 9">
                        <p class="error-description">未查找到，重新查找~</p>
                    </tr>
                @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
    <div class="page_list"  align=" right" >
        <ul>
            {!!$orderList->render()!!}
        </ul>

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

    //
    function isdel(obj,sn){
        layer.confirm('删除后可在回收站查找',function (index) {
            var url = '/admin/service/order/del'
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





//用户禁用
    function member_stop( obj,id){
        layer.confirm('确认要禁用id:'+id+' 的用户吗？',function (index) {
            $.ajax({
                type:'post',
                url:'/admin/service/member/enable',
                dateType:'json',
                data: {
                    _enable:0,
                         id: id,
                     _token:"{{csrf_token()}}"
                },

                success:function(data){
                    $(obj).parents("tr").find(".td-manage").prepend(
                        ' <a style="text-decoration:none" onClick="member_start( this,'+id+')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>'
                    );
                    //
                    $(obj).parents('tr').find('.td-status').html('<span class="label label-defaunt radius">已停用</span>');

                  $(obj).remove();
                  layer.msg('已停用！',{icon:5,time:1000});

                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:2000});
                },

            });
        });

    }
    //用户解禁
    function member_start(obj ,id){
        layer.confirm('确认要解封id:' +id+'的用户吗？',function(index){
            $.ajax({
                type:'post',
                url:'/admin/service/member/enable',
                dataType:'json',
                data:{
                    _enable:1,
                    id:id,
                     _token:"{{csrf_token()}}"
                },
                success:function(data){
                    $(obj).parents("tr").find(".td-manage").prepend(
                        ' <a style="text-decoration:none" onClick="member_stop( this,'+id+')" href="javascript:;" title="禁用"><i class="Hui-iconfont">&#xe631;</i></a>'
                    );
                    //
                    $(obj).parents('tr').find('.td-status').html('');

                    $(obj).remove();
                    layer.msg('已启用！',{icon:6,time:1000});

                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:2000});
                },
            });

        });
    }

    //取消订单
    function member_del(obj,name,id) {
        layer.confirm('确认要删除用户:'+ name +' 吗？',function(index){
            $.ajax({
                    type:'post',
                     url:'/admin/service/member/del',
                dateType:'json',
                    data:{
                          member_id:id,
                        _token:"{{csrf_token()}}"
                },
                success: function(data) {

                    layer.msg('删除成功', {icon:1, time:2000});
                    location.replace(location.href);
                    //无刷新删除数据,但是分页没法改变
                   // $(obj).parent().parent().remove();//
                   // var tot = Number($('#tot').html());
                   // $('#tot').html(--tot);
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:2000});
                },
            });
        });
    }



</script>

@endsection