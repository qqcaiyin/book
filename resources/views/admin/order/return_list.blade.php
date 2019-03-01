@extends('admin.master')
<style>

    .table1 tr{
        border-collapse: collapse;
        border:1px solid #e2e2e2;
    }
    .table1 ,td{
        border:0px;
    }

</style>
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 订单 <span class="c-gray en">/</span> 订单管理 <span class="c-gray en">/</span>退换货管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c">
                <th width="8%" style="text-align: left;">退换货 </th>
                <th width="10%">订单号</th>
                <th width="30%" style="text-align: left;">商品名称</th>
                <th width="20%">申请时间</th>
                <th width="10%">状态</th>
                <th width="10%">操作</th>
            </tr>
            </thead>
            @if($applyList->total()>0)
            <tbody>
                @foreach($applyList as $v)
                    <tr class="text-c">
                        <td style="text-align: left;">
                            @if($v->state == 1)<p>[换货]</p>
                            @elseif($v->state == 2)<p>[退货]</p>
                           @endif
                        </td>
                        <td >{{$v->order_sn}}</td>
                        <td style="text-align: left;" >
                            <a   target="_blank" href="{{url('/product/' . $v->product_id)}}">{{$v->product_name}}                             @if($v->spec_value !='')     [{{$v->spec_value}}]@endif
                            </a>
                        </td>
                        <td>{{$v->apply_time}}</td>
                        <td>
                            @if($v->status == 0)待审核
                            @elseif($v->status == 1)处理中
                            @elseif($v->status == 2) 审核不通过
                            @elseif($v->status == 3) 已取消
                            @elseif($v->status == 4) 已完成
                            @endif
                        </td>
                        <td><a href="{{'/admin/servicedetails?sn='.$v->return_sn }}" style="color: #007cc3;">查看</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="page_list"  style="text-align: right;" >
            {!!$applyList->render()!!}
        </div>
        @else
        </tbody>
        </table>
        <div align="center">
            <h3>没有相关数据<i class="Hui-iconfont">&#xe688;</i></h3>
        </div>
        @endif
    </div>

</div>

    <!--
<div  id="main" style="width:80%; height:400px;" >
</div>
-->



@endsection

@section('my-js')
    <script src="/js/echarts.min.js"></script>

    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例

$(function(){

    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    option = {
        title : {
            //   text: '未来一周气温变化',
            //    subtext: '纯属虚构'
        },
        tooltip : {
            trigger: 'axis'
        },
       // color:['#007cc3'],
        legend: {
            //     data:['最高气温']
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                // dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : []
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLabel : {
                    formatter: '{value}'
                }
            }
        ],
        series : [
            {
                //  name:'最高气温',
                type:'line',
                data:[],
                markPoint : {
                    data : [
                        {type : 'max', name: '最大值'},
                        {type : 'min', name: '最小值'}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name: '平均值'}
                    ]
                }
            },
        ]
    };





    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);

    myChart.showLoading({text: '正在拼命读取数据...'});
    $.get('/admin/service/stat_sale',{act:'get_sale',year:'2019',month:'1'},function(res){
        myChart.hideLoading();
        myChart.setOption({
            xAxis: {
                data: res.data.cat
            },
            series: [{
                // 根据名字对应到相应的系列
              //  name: '订单量',
                type:'line',
                data: res.data.data,

            }]


        });
    },'json');




    function query_total(){
        ;
    }









});





    </script>


    <script type="text/javascript">
        //添加会员等级
        function  grade_add(){
            var name = $('input[name=name]').val();
            var min_core = $('input[name=min_core]').val();
            var max_core = $('input[name=max_core]').val();
            var discount = $('input[name=discount]').val();
            $.ajax({
                type:'post',
                url:'/admin/service/member/grade_add',
                dataType: 'json',
                data:{
                    name:name,
                    min_core:min_core,
                    max_core:max_core,
                    discount:discount,
                    _token:"{{csrf_token()}}"
                },
                success:function(data){
                    if(data.status == 0){
                        //插入数据库成功
                        var  node =
                            '<tr class="text-c">'+
                            '<td style="text-align: left;"><input type="text"   class="input-mi" onchange="_change(this,\'name1\','+ data.newid+')"  value=" '+name+'" ></td>'+
                            '<td style="text-align: left;"><input type="text" style=" width:80px;"  class="input-mi" onchange="_change(this,\'mincore1\','+ data.newid+')"  value=" '+min_core+'" ></td>'+
                            '<td style="text-align: left;"><input type="text" style=" width:80px;"  class="input-mi" onchange="_change(this,\'maxcore1\','+ data.newid+')"  value=" '+max_core+'" ></td>'+
                            '<td style="text-align: left;"><input type="text" style=" width:80px;"  class="input-mi" onchange="_change(this,\'discount1\','+ data.newid+')"  value=" '+discount+'" ></td>'+
                            '<td style="text-align: left;"><input type="text" style=" width:80px;" class="input-mi" onchange="_change(this,\'sort1\','+ data.newid+')"  value=" '+0+'" ></td>'+
                            '<td class="td-manage"> <a title="删除" href="javascript:;" onclick="grade_del(this,'+data.newid+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td> </tr>';
                        $('.table1').append(node);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:3000});
                },
            });
        }

        //保存更改的值
        function  _change(obj,tp,id){
            //获得变动后的值
            var changeValue = $(obj).val();
            $.ajax({
                type: 'post',
                url: '/admin/service/member/grade', // 需要提交的 url
                dataType: 'json',
                data: {
                    id: id,
                    tp:tp,
                    changeValue :changeValue,
                    _token: "{{csrf_token()}}"
                },
                success: function(data) {
                    console.log(data);
                    if(data.status == 1|| data.status == 2){
                        var order= data.status==1? 99:0;
                        $(obj).val(order);
                        layer.msg(data.message, {icon:1, time:2000});
                        return ;
                    }
                    if(data == null) {
                        layer.msg('服务端错误', {icon:2, time:3000});
                        return;
                    }
                    layer.msg(data.message, {icon:1, time:3000});
                },
                error: function(xhr, status, error) {
                    layer.msg('ajax error', {icon:2, time:3000});
                },
            });

        }

        //删除会员等级
        function grade_del(obj,id) {
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type:'post',
                    url:'/admin/service/member/grade_del',
                    dataType:'json',
                    data:{
                        id:id,
                        _token:"{{csrf_token()}}"
                    },
                    success: function(data) {
                        if(data.status == 0){
                            layer.msg('删除成功', {icon:1, time:2000});
                            //无刷新删除
                            $(obj).parent().parent().remove();
                            return ;
                        }
                        layer.msg('bug', {icon:1, time:2000});
                    },
                    error: function(xhr, status, error) {
                        layer.msg('ajax error', {icon:2, time:2000});
                    },
                });
            });
        }



    </script>

@endsection