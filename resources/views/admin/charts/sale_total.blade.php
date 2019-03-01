@extends('admin.master')
<style>

    .table1 tr{
        border-collapse: collapse;
        border:1px solid #e2e2e2;
    }
    .table1 ,td{
        border:0px;
    }

    .it-list span{
        border-top:1px solid #ddd;
        border-bottom:1px solid #ddd;
        border-top:1px solid #ddd;
        border-right:1px dashed #ddd;
        padding: 6px 15px;
        cursor: pointer;
        float: left;
    }
    .selected{
        background-color: #8181a7;
    }

</style>
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 订单 <span class="c-gray en">/</span> 订单管理 <span class="c-gray en">/</span>退换货管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <div class="mt-20">
        <p style="width:100%; text-align: center;  font-size: 18px; font-weight: bolder; ">销售统计</p>

        <div style=" margin-left:100px; ">
            <span style=" display: inline-block; min-width:150px; height:80px; border: 1px solid #ddd;border-radius: 4px; text-align: center;">
                <span style="width:100%;  font-size: 25px; color:#fea970;">
                    {{$totalSale['money']}}
                </span><br>
                累计销售金额
            </span>
            <span style=" display: inline-block; min-width:150px; height:80px; border: 1px solid #ddd;border-radius: 4px; text-align: center;">
                <span style="width:100%;  font-size: 25px; color:#fea970;">
                    {{$totalSale['num']}}
                </span><br>
                累计销售数量
            </span>
        </div>

        <div style=" margin-left: 100px; margin-top: 40px;">
            <input type="radio"  id="groupby"  checked  name="groupby"  value="year" ><label for="groupby">按年</label>
            <input type="radio"  id="groupby"   name="groupby"  value="month" ><label for="groupby">按月</label>
        </div>

        <div  class="ladder-mod"   style=" width: 100%; height:100px;margin-left: 100px; margin-top:10px; vertical-align: middle; ">
            <div class="year" style="float: left; width: 100%;">
                <span style=" float: left; ">年份</span>
                <input type="hidden" id="year-y"  value="2017" >
                <div class="it-list" style="float: left;margin-left: 10px; ">
                    <span data-id="2017"  style="  border-left:1px solid #ddd;" class="selected">2017</span>
                    <span data-id="2018" >2018</span>
                    <span data-id="2019"style="  border-right:1px solid #ddd;">2019</span>
                </div>
            </div>
            <div class="month"   style="float: left; width: 100%; margin-top: 10px; display: none; ">
                <span style=" float: left; ">月份</span>
                <input type="hidden" id="month-y"  value="0" >
                <div class="it-list" style="float: left;margin-left: 10px; ">
                    <span data-id="1" style="  border-left:1px solid #ddd;">1月</span>
                    <span data-id="2">2月</span>
                    <span data-id="3">3月</span>
                    <span  data-id="4">4月</span>
                    <span  data-id="5">5月</span>
                    <span  data-id="6">6月</span>
                    <span  data-id="7">7月</span>
                    <span  data-id="8">8月</span>
                    <span  data-id="9">9月</span>
                    <span data-id="10">10月</span>
                    <span data-id="11">11月</span>
                    <span  data-id="12" style=" border-right:1px solid #ddd;">12月</span>
                </div>
            </div>
        </div>
        <div  id="main" style="width:80%; height:400px;" >

        </div>
    </div>

</div>

<div  id="main" style="width:90%; height:400px; " >



</div>




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
        color:['#007cc3'],
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

    query_salenum();

    $('.year .it-list span').click(function(){
      var   v =$(this).data('id');
        $('#year-y').val(v);
        $(this).addClass('selected');
        $(this).siblings('span').removeClass('selected');
        query_salenum();

    });
    $('.month .it-list span').click(function(){
        var   v =$(this).data('id');
        $('#month-y').val(v);
        $(this).addClass('selected');
        $(this).siblings('span').removeClass('selected');
        query_salenum();
    });

    $('input[name=groupby]').change(function(){
       if( $('input[name]:checked').val() =='month' ){
           $('.month').show();
       }else{
           $('.month').hide();
        }

    });




    function query_salenum(){

        var groupby = $("input[name='groupby']:checked").val(),
            year =0,
            month=0;
        switch (groupby){
            case 'year':
                year = $("#year-y").val();
                month=0;
                if(year ==0){
                    return;
                }
                break;
            case 'month':
                year = $("#year-y").val();
                month = $("#month-y").val();
                if(month == 0 ||year ==0){
                    return;
                }
                break;
            case 'day':
                break;
            default:
                break;
        }

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);

        myChart.showLoading({text: '正在拼命读取数据...'});
        $.get('/admin/service/stat_sale',{act:'get_sale',year:year,month:month},function(res){
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



    }

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