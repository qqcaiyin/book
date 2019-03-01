@extends('admin.master')
<style>
    .table1 tr{
        border-collapse: collapse;
        border:1px solid #e2e2e2;
    }
    .table1 ,td{
        border:0px;
    }
    .input-mi{
        border: 0px;
        outline:none;
        cursor: pointer;
        text-align: center;
        width:200px;
        height:25px;
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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 产品 <span class="c-gray en">/</span> 产品分类管理 <span class="c-gray en">/</span> 分类列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

    <div class="cl pd-5 mt-20" >
        <span class="l">
            <a class="btn btn-primary radius" href="{{url('/admin/market/skipe_add')}}"  data-toggle="tooltip" data-placement="bottom" title="添加"><i class="Hui-iconfont">&#xe604;</i>添加</a>
        </span>

    </div>

    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c">
                <th width=""  style="text-align:left;" >活动名称</th>
                <th width="15%">活动时间</th>
                <th width="5%">启用</th>
                <th width="10%">优惠类型</th>
                <th width="10%">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($skipeList as $v)
                <tr class="text-c">
                    <td style="text-align: left;">{{$v->name}}</td>
                    <td>{{ date('Y-m-d H:i:s',$v->starttime)}}<br>
                        {{ date('Y-m-d H:i:s',$v->endtime)}}
                    </td>
                    <td></td>
                    <td>
                    @if($v->ty ==1)

                    @elseif($v->ty==2)
                        直降
                    @elseif($v->ty==3)
                        折扣
                    @endif

                    </td>
                    <td>
                        <a style="text-decoration:none" class="ml-5" href="{{url('/admin/market/skipe_edit?id=' . $v->id)}}" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                            <a style="text-decoration:none" class="ml-5" onClick="category_del('{{$v->name}}',{{$v->id}})"
                               href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe60b;</i>
                            </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('my-js')

<script type="text/javascript">

    function addCategory(title,url,id){
        layer_show(title,url,'','')

    }
    function category_edit(title,url){
        layer_show(title,url,'','');
    }
    //
    function  _change(obj,tp,id){
        var changeValue = $(obj).val();
        $.ajax({
            type: 'post',
            url: '/admin/service/category/changevalue', // 需要提交的 url
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
                if(data.status == 3){
                    //上架
                   // $(obj).remove();
                    $(obj).parents('tr').find('.td-status').html('<span class="label label-success radius" onclick="_change(this,\''+tp+'\','+id+')">是</span>');
                    layer.msg(data.message,{icon:6,time:1000});
                    return
                }
                if(data.status == 4){
                    //下架
                   // $(obj).remove();
                    $(obj).parents('tr').find('.td-status').html('<span class="label label-defaunt radius" onclick="_change(this,\''+tp+'\','+id+')">否</span>');
                    layer.msg(data.message,{icon:5,time:1000});
                    return
                }
                if(data == null) {
                    layer.msg('服务端错误', {icon:2, time:3000});
                    return;
                }
                layer.msg(data.message, {icon:1, time:3000});
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
                layer.msg('ajax error', {icon:2, time:3000});
            },
        });

    }
    /**
     * 删除分类
     *
     */
    function category_del(obj,id){
        layer.confirm('确认要删除抢购活动： '+ obj +' 吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin/service/market', // 需要提交的 url
                dataType: 'json',
                data: {
                    act:'del_skipe',
                     id :id,
                     _token: "{{csrf_token()}}"
                },
                success: function(data) {
                    console.log(data);
                    if(data == null) {
                        layer.msg('服务端错误', { time:2000});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, { time:2000});
                        return false;
                    }
                    layer.msg(data.message, { time:2000});
                    location.replace(location.href);
                    location.replace(location.href);

                },
            });
        });
    }

</script>

@endsection