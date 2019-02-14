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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 管理员 <span class="c-gray en">&gt;</span> 角色 <span class="c-gray en">&gt;</span> 角色列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5  "> <span class="l">  <a class="btn btn-primary radius" href="{{url('/admin/account/role_add')}}" ><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> </div>
    <table class="table  table-hover table-bg  table1 ">
        <thead>
        <tr class="text-c">
            <th width="200" style="text-align: left">角色名称</th>
            <th width="">描述</th>
            <th width="10%">是否开启</th>
            <th width="10%">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
        <tr class="text-c">
            <td style="text-align: left">{{$role->name}}</td>
            <td>{{$role->desc}}</td>
            <td class="td-status">
                @if($role->is_open == 1)
                    <a  href="javascript:;"  class="label label-success radius open" onclick="_change(this,0,{{$role->id}})" >是</a>
                    <input type="hidden" name="is_open" value="1">
                @else
                    <a  href="javascript:;"  class="label label-defaunt radius open" onclick="_change(this,1,{{$role->id}})">否</a>
                    <input type="hidden" name="is_open" value="0">
                @endif
            </td>
            <td class="f-14"><a title="编辑" href="{{url('/admin/account/role_edit/' .$role->id )}}"  style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="_del(this,{{$role->id}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('my-js')

<script type="text/javascript">


    /*管理员-角色-删除*/
    function _del(obj,id){
        layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/admin/service/account/role/del', // 需要提交的 url
                dataType: 'json',
                data:{
                    id: id,
                    _token: "{{csrf_token()}}"
                },
                success: function(data){
                    if(data.status == 0)
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    //  if(s == 1)
    //  {
    //       $(this).removeClass('label-success').addClass('label-defaunt').html('否');
    //       $(this).next().val(0);
    //   }else{
    //       $(this).removeClass('label-defaunt').addClass('label-success').html('是');
    //       $(this).next().val(1);
    //  }
    /**
     * 规格选择
     * @return
     */
    function  _change(obj,tp,id){
        var s = $(obj).val();
        $.ajax({
            type: 'post',
            url: '/admin/service/account/role/open', // 需要提交的 url
            dataType: 'json',
            data: {
                id: id,
                tp:tp,
                _token: "{{csrf_token()}}"
            },
            success: function(data) {
                if(data == null) {
                    layer.msg('服务端错误', {icon:2, time:2000});
                    return;
                }
                if(data.status == 0) {
                    if(tp ==1){
                        $(obj).parents('tr').find('.td-status').html('<span class="label label-success radius" onclick="_change(this,\''+0+'\','+id+')">是</span>  ');
                        layer.msg('启用', {icon:1, time:2000});
                    }
                    if(tp == 0){
                        $(obj).parents('tr').find('.td-status').html('<span class="label label-defaunt radius" onclick="_change(this,\''+1+'\','+id+')">否</span>  ');
                        layer.msg('禁用', {icon:2, time:2000});
                    }
                    return;
                }
                layer.msg(data.message, {icon:2, time:3000});
            },
            error: function(xhr, status, error) {
                layer.msg(error, {icon:2, time:3000});
            },
        });
    }
</script>

@endsection