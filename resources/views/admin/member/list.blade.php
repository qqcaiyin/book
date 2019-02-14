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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 会员 <span class="c-gray en">/</span> 会员管理 <span class="c-gray en">/</span> 会员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">

    <div class="cl pd-5  " >
        <span class="l">
            <a class="btn btn-primary radius" onclick="member_add('会员/会员管理/添加会员','/admin/member_add')" href="javascript:;"><i class="Hui-iconfont">&#xe604;</i> 添加会员</a>
         <a class="btn btn-primary radius" onclick="checkbox_del(' > 删除','/admin/product_add')" href="javascript:;"><i class="Hui-iconfont">&#xe60b;</i>删除</a>
            <a class="btn btn-primary radius" href="{{ url('admin/product/recycle') }}"><i class="Hui-iconfont">&#xe609;</i>回收站</a>
        </span>
        <form method="get" name="form1"  action="">
        <div class="text-c" align="right" style="float:  right;">
            <span class="select-box inline" style=" width:80px;"data-toggle="tooltip" data-placement="bottom" title="账号状态">
		   <select class="select" name="enable" size="1">
                <option value="2">全部</option>
                   <option    value="0">账号禁用</option>
                    <option    value="1">账号正常</option>
           </select>
		</span>
            <input type="text" style="display: none" name="is_search" value="1">
            <input type="text" placeholder="请输入 用户名"  class="input-text ac_input" name="keywords" value="" id="search_text" autocomplete="off" style="width:200px"><input  type="submit" class="btn btn-default" >
        </div>
        </form>
    </div>
        <div class="mt-20">
            <table class="table  table-hover table-bg  table1">
                <thead>
                <tr class="text-c">
                    <th width="15"><input type="checkbox" name="" value=""></th>
                    <th width="40">ID</th>
                    <th width="100">昵称</th>
                    <th width="100">手机号</th>
                    <th width="150">邮箱</th>
                    <th width="150">可用余额</th>
                    <th width="80">积分</th>
                    <th width="50">会员等级</th>
                    <th width="130">加入时间</th>
                    <th width="50">邮箱激活状态</th>
                    <th width="50">禁用</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @if($members != null)
                @foreach($members as $member)
                <tr class="text-c">
                    <td><input type="checkbox" value="1" name=""></td>
                    <td>{{$member->id}}</td>
                    <td><u style="cursor:pointer" class="text-primary" onclick="member_show('{{$member->nickname}}','/admin/member/member_show/{{$member->id}}','360','400')" data-toggle="tooltip" data-placement="top" title="点击查看">{{$member->nickname}}</u></td>
                    <td>{{$member->phone}}</td>
                    <td>{{$member->email}}</td>
                    <td>{{$member->openbalance}}</td>
                    <td>{{$member->point}}</td>
                    <td>VIP{{$member->vip}}</td>
                    <td>{{$member->register_time}}</td>
                    <td class="td-status1">
                            @if(($member->active == 1) && ($member->email != null))
                            <span class="label label-success "> 已激活</span>
                            @else
                            <span class="label  "> 未激活</span>
                            @endif

                    </td>
                    <td class="td-status">
                            @if($member->enable == 0)
                            <span class="label label-defaunt radius">已停用</span>
                            @else

                            @endif
                    </td>
                    <td class="td-manage">
                        @if($member->enable == 0)
                            <a style="text-decoration:none" onClick="member_start( this,{{$member->id}})" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>
                        @else
                            <a style="text-decoration:none" onClick="member_stop( this,{{$member->id}})" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
                        @endif
                      <!--  <a title="编辑" href="javascript:;" onclick="member_edit('编辑','admin/member_edit','4','','510')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>-->
                        <a style="text-decoration:none" class="ml-5" onClick="change_money('','/admin/member_money/{{$member->id}}','800','500')" href="javascript:;" title="资调整金"><i class="Hui-iconfont">&#xe6b4;</i></a>
                        <a title="删除" href="javascript:;" onclick="member_del(this,'{{$member->nickname}}',{{$member->id}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
                 @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
    <div class="page_list"  align=" right" >
        <ul>
            {!!$members->render()!!}
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