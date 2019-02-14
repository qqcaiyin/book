@extends('admin.master')

@section('content')

    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 产品 <span class="c-gray en">/</span> 产品类型管理 <span class="c-gray en">/</span> 类型列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5  mt-20" >
        <span class="l">
            <a class="btn btn-primary radius" href="{{url('/admin/type_add')}}"><i class="Hui-iconfont">&#xe604;</i> 添加</a>
         <a class="btn btn-primary radius" onclick=" checkbox_del(' > 删除','/admin/product_add')" href="javascript:;"><i class="Hui-iconfont">&#xe60b;</i>删除</a>
        </span>
    </div>

    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c">
                <th width="15"><input type="checkbox" name="checkBox" value=""></th>
                <th width="30%"  >类别名称</th>
                <th width="">属性</th>
                <th width="10%">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $pdt_types as $pdt_type)
             <tr class="text-c">
                 <td><input type="checkbox" value="" name=""></td>
                 <td > {{$pdt_type->name}}</td>
                <td>
                    @foreach($pdt_type->attr as $attr)
                    [{{$attr->name}}]
                    @endforeach
                </td>
                <td class="f-14 td-manage">
                    <a style="text-decoration:none" class="ml-5"
                       href="{{url('/admin/type_edit/'.$pdt_type->id)}}" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
                    </a>
                    <a style="text-decoration:none" class="ml-5"
                           onClick="type_del('{{$pdt_type->name}}',{{$pdt_type->id}})"
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
                    $(obj).parents('tr').find('.td-status').html('<span class="label label-defaunt radius" onclick="_change(this,\''+tp+'\','+id+')">是</span>');
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
    function type_del(obj,id){
        layer.confirm('确认要删除类别： '+ obj +' 吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin/service/type/del', // 需要提交的 url
                dataType: 'json',
                data: {
                    // total:,
                     id :id,
                     _token: "{{csrf_token()}}"
                },
                success: function(data) {
                    console.log(data);
                    if(data == null) {
                        layer.msg('服务端错误', {icon:2, time:2000});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, {icon:2, time:2000});
                        return;
                    }
                    layer.msg(data.message, {icon:1, time:2000});
                    location.replace(location.href);
                  //  location.href='category?page='+data.pagenum;

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
    /**
     * 选择要显示的分类
     *
     */
    function  select_category(){
          var parent_id = $('select[name=parent_id] option:selected').val();
        //  alert(parent_id);
          location.href = "/admin/category?parent_id="+parent_id;

    }
</script>

@endsection