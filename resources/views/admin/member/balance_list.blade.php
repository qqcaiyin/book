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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 会员 <span class="c-gray en">/</span> 会员管理 <span class="c-gray en">/</span>账户变动 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <form  method="get" name="form1"   action="{{url('/admin/balance/log_search')}}" >
    <div class="cl pd-5  mt-20" >
        <input type="text" placeholder="完整的会员账号"  class="input-text ac_input" name="nickname" value="@if(!empty($balance_logs->ser)){{$balance_logs->ser['nickname']}}  @endif" id="search_text" style="width:150px">
        <label >日期</label>
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate"  name=" starttime"  style="width:120px;"  value="@if(!empty($balance_logs->ser)){{$balance_logs->ser['starttime']}}  @endif">
        -
        <input type="text"   name="endtime"onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:120px;"  value="@if(!empty($balance_logs->ser)){{$balance_logs->ser['endtime']}}  @endif">
        <input type="submit" class="btn btn-default" id="search_button"></input>
    </div>
    </form>
    {{$balance_logs['nickname']}}
    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c">
                <th width="100" style="text-align: left;">会员 {{$balance_logs['nickname']}}</th>
                <th width="100">类型</th>
                <th width="100">变动值</th>
                <th width="">明细</th>
                <th width="200">时间</th>
            </tr>
            </thead>
            @if($balance_logs->total()>0)
            <tbody>
                @foreach($balance_logs as $balance_log)
                    <tr class="text-c">
                        <td style="text-align: left;">{{$balance_log->nickname}}</td>
                        <td>
                            @if($balance_log->type == 0) 余额动态
                            @elseif($balance_log->type == 3 ) 积分动态
                            @endif
                        </td>
                        <td>
                            @if($balance_log->pm ==0) <span style="color:red;">-{{$balance_log->num}} </span>
                            @elseif($balance_log->pm == 1 ) <span style="color:green;">+{{$balance_log->num}} </span>
                           @endif
                        </td>
                        <td>{{$balance_log->desc}}</td>
                        <td>{{date('Y-m-d h:m:s',$balance_log->time)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="page_list"  align=" right" >
            {!!$balance_logs->render()!!}
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




@endsection

@section('my-js')

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