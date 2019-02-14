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
            <a class="btn btn-primary radius" onclick="addCategory('>>添加类别','/admin/category_add')" href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="添加类别"><i class="Hui-iconfont">&#xe604;</i> 添加类别</a>
            <a href="/admin/excel/export" data-toggle="tooltip" data-placement="bottom" title="导出分类统计表" class="btn btn-primary  radius"><i class="Hui-iconfont">&#xe644;</i> 导出数据</a>
        </span>
        <div class="text-c" style="float: right;">
        <span class="select-box inline" style=" width:200px;">
		   <select class="select" name="parent_id" size="1">
                <option value="0">全部分类</option>
               @foreach($cate as $c)
                   @if($c->id == $categories->selected)
                       <option   selected value="{{$c->id}}">{{$c->name}}</option>
                   @else
                       <option    value="{{$c->id}}">{{$c->name}}</option>
                   @endif
               @endforeach
           </select>
		</span>
            <a  class="btn btn-default" id="search_button" onclick="select_category()" >选择分类</a>
        </div>
    </div>

    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c">
                <th width="15"><input type="checkbox" name="checkBox" value=""></th>
                <th width=""  style="text-align:left;" >商品类别</th>
                <th width="5%">排序</th>
                <th width="5%">首页显示</th>
                <th width="10%">添加子类</th>
                @if(  in_array('CategoryDel' ,(Session::get('admin_info'))[1] ) ||
                      in_array('CategoryEdit' ,(Session::get('admin_info'))[1] )||
                      ( !Session::get('rbac_open')) )
                <th width="10%">操作</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach( $categories as $category)
             <tr class="text-c">
                 <td><input type="checkbox" value="" name=""></td>
                <td style="text-align:left;" >
                        @if($category->tot == 0)
                            <li style="list-style-type:disc"> &nbsp;&nbsp;&nbsp;
                                <input type="text"  class="input-mi" onchange="_change(this,'name',{{$category->id}})"  value=" {{$category->name}}" ></li>
                        @else
                            <li style="list-style-type:none">
                                @for ($i = 1; $i < $category->tot; $i++)
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                    &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;
                                @endfor
                                    &nbsp; &nbsp;&nbsp;&nbsp;|------------
                                    <input type="text" class="input-mi" onchange="_change(this,'name',{{$category->id}})"  value=" {{$category->name}}" >
                                   </li>
                        @endif

                </td>
                <td ><input type="text" class="input-mi" style=" border: solid  1px #e2e2e2;text-align: center; width:40px; height:25px;text-align:center;display:inline;" onchange="_change(this,'order',{{$category->id}})"  value="{{$category->category_no}}" data-toggle="tooltip" data-placement="bottom" title="0~99"></td>
                 <td class="td-status">
                     @if($category->is_show == 0)
                         <span class="label label-defaunt radius" onclick="_change(this,'is_show',{{$category->id}})">否</span>
                     @else
                         <span class="label label-success radius" onclick="_change(this,'is_show',{{$category->id}})">是</span>
                     @endif
                 </td>
                <td>
                    <a class="btn1 btn-primary radius" onclick="addCategory('[ {{$category->name}} ] >添加子类','/admin/category_addson/{{$category->id}}')" href="javascript:;" data-toggle="tooltip" data-placement="right" title="添加子类">添加子类</a>
                </td>
                 @if( (in_array('CategoryDel' ,(Session::get('admin_info'))[1] ) ||
                        in_array('CategoryEdit' ,Session::get('admin_info'))[1] ) ||
                        (!Session::get('rbac_open') ))
                <td class="f-14 td-manage">
                    @if(  in_array('CategoryEdit' ,(Session::get('admin_info'))[1] )||(!Session::get('rbac_open')) )
                    <a style="text-decoration:none" class="ml-5"
                       onClick="category_edit(
                             '类别编辑',
                              '/admin/category_edit/{{$category->id}}'
                              )"
                       href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
                    </a>
                    @endif
                    @if(  in_array('CategoryDel' ,(Session::get('admin_info'))[1] )||(!Session::get('rbac_open')) )
                    <a style="text-decoration:none" class="ml-5" onClick="category_del('{{$category->name}}',{{$category->id}})"
                                href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe60b;</i>
                    </a>
                    @endif
                </td>
                 @endif
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
        layer.confirm('确认要删除类别： '+ obj +' 吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin/service/category/del', // 需要提交的 url
                dataType: 'json',
                data: {
                    // total:,
                     page: location.href,
                     category_id :id,
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
                        return false;
                    }
                    layer.msg(data.message, {icon:1, time:2000});
                    location.replace(location.href);
                    location.href='category?page='+data.pagenum;

                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:2000});
                },
               // beforeSend: function(xhr){
               //     layer.load(0, {shade: false});
              //  },
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