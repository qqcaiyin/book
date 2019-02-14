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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i>管理员 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5  ">
        <span class="l">
            <a class="btn btn-primary radius" href="{{url('/admin/account/admin_add')}}" ><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a>
        </span>
    </div>
    <table class="table  table-hover table-bg  table1 ">
        <thead>
        <tr class="text-c">
            <th width="200" style="text-align: left">管理员名称</th>
            <th width="">上次登录时间</th>
            <th width="10%">上次登录IP</th>
            <th width="10%">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($admins as $admin)
        <tr class="text-c">
            <td style="text-align: left">{{$admin->name}}</td>

            <td >{{date('Y-m-d H:i:s',$admin->last_time)}}</td>
            <td width="70">{{$admin->last_ip}}</td>
            <td class="f-14"><a title="编辑" href="javascript:;" onclick="admin_role_edit('角色编辑','admin-role-add.html','1')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_role_del(this,'1')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('my-js')

<script type="text/javascript">


    /*管理员-角色-删除*/
    function admin_role_del(obj,id){
        layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '',
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /**
     * 规格选择
     * @return
     */
    $('.open').click(function(){
        var s= $(this).next().val();
        if(s == 1)
        {
            $(this).removeClass('label-success').addClass('label-defaunt').html('否');
            $(this).next().val(0);
        }else{
            $(this).removeClass('label-defaunt').addClass('label-success').html('是');
            $(this).next().val(1);
        }
    });
</script>

@endsection