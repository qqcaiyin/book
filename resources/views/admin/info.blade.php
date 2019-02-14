@extends('admin.master')


@section('content')
    <style>
        span{
            font-weight: bolder;
        }
        a{

            margin-left: 50px;
            font-weight: bolder;
        }
        a:hover{
            text-decoration: none;
        }

    </style>

    <div class="panel panel-default" style="  float: left;width:95%; margin: 20px 35px 0px 35px; ">

        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/a.png">
            </div>
            <div style="vertical-align: top; float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/a.png">
            </div>
            <div style="vertical-align: top;  float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/a.png">
            </div>
            <div style="vertical-align: top; float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/a.png">
            </div>
            <div style="vertical-align: top;  float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/a.png">
            </div>
            <div style="vertical-align: top; float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/b.png">
            </div>
            <div style="vertical-align: top; float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/b.png">
            </div>
            <div style="vertical-align: top;  float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/b.png">
            </div>
            <div style="vertical-align: top; border: 1px solid red; float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/b.png">
            </div>
            <div style="vertical-align: top; border: 1px solid red; float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/b.png">
            </div>
            <div style="vertical-align: top;  float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>
        <div class="panel-body" style="vertical-align: top; float: left;">
            <div style=" float: left;">
                <img  style="height: 100px;width: 100px; border: 1px solid red; " src="/images/b.png">
            </div>
            <div style="vertical-align: top;  float: left;">新评论待回复 <br>
                <a  style = "margin-left: 12px;padding: 5px;"href="">9</a>个
            </div>
        </div>

    </div>


<div class="panel panel-default" style="width: 45%; float: left; margin-top: 30px; margin-left: 35px;">
    <div class="panel-header"><i class="Hui-iconfont">&#xe681;</i>系统信息</div>
    <div class="panel-body"><span>当前版本号 </span></div>
    <div class="panel-body"><span>最新版本号 </span></div>
    <div class="panel-body"><span>官网地址</span></div>
    <div class="panel-body"><span>服务器软件</span></div>
    <div class="panel-body"><span>附件上传容量</span></div>
    <div class="panel-body"><span>授权信息</span></div>
</div>
<div class="panel panel-default" style="width: 45%; float: right; margin-top: 30px; margin-right: 35px;">
    <div class="panel-header"><i class="Hui-iconfont">&#xe61c;</i>基础统计</div>
    <div class="panel-body"><span>销售总额</span></div>
    <div class="panel-body"><span>注册用户</span><a href ="/admin/member" style="color: #0a6999;">{{$data['memberTotal']}} 个</a></div>
    <div class="panel-body"><span>产品数量</span><a href ="/admin/product" style="color: #0a6999;">{{$data['productTotal']}} 个</a></div>
    <div class="panel-body"><span>品牌数量</span><a href ="/admin/member" style="color: #0a6999;">{{$data['memberTotal']}} 个</a></div>
    <div class="panel-body"><span>订单数量 </span><a href ="/admin/order" style="color: #0a6999;">{{$data['orderTotal']}} 个</a></div>
    <div class="panel-body"><span>库存预警</span></div>
</div>
<div style="float:left;  width:95%; height:10px; margin-left: 35px;background-color: #0a6999;">  </div>
<div class="panel panel-default" style="  float: left;width:95%; margin: 20px 35px 0px 35px; ">
    <div class="panel-header"><i class="Hui-iconfont">&#xe6f2;</i> &nbsp;最新 10 条 待处理订单</div>
    <div class="mt-20">
        <table class="table  table-hover table-bg table1 " >
            <thead>
            <tr class="text-c">

                <th width="10%" style="text-align: left;">订单号</th>
                <th width="8%">状态</th>
                <th width="10%">收货人</th>
                <th width="10%">订单金额</th>
                <th width="">下单时间</th>
                <th width="10%">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data['orderList'] as $value)
            <tr class="text-c">
                <td width="10%" style="text-align: left;">{{$value['order_sn']}}</td>
                <td width="8%">{{$value['status_name']}}</td>
                <td width="10%">{{$value['consignee']}}</td>
                <td width="10%"><span style=" color: red">{{$value['order_amount']}}</span></td>
                <td width="10%">{{date('Y-m-d H:i:s',$value['add_time'])}}</td>
                <td width="10%">
                    <a style="text-decoration:none" class="ml-5"  href="/admin/order/info?do=details&amp;id={{$value['order_sn']}}" title="查看详情"><i class="Hui-iconfont">&#xe6c5;</i></a>
                    <a title="删除" href="/admin/order"  class="ml-5" style="text-decoration:none"><i class="Hui-iconfont" >&#xe60b;</i></a>
                </td>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('my-js')


@endsection