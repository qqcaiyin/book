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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 产品 <span class="c-gray en">/</span> 产品管理 <span class="c-gray en">/</span> 产品回收站 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 mt-20" >
        <span class="l">
            <a class="btn btn-primary radius"  href="{{url('/admin/product')}}"><i class="Hui-iconfont">&#xe67d;</i> 返回列表</a>
         <a class="btn btn-primary radius" onclick="checkbox(' 确定要彻底删除勾选的产品吗','delete')" href="javascript:;"><i class="Hui-iconfont">&#xe6a6;</i>彻底删除</a>
            <a class="btn btn-primary radius" onclick="checkbox(' 确定要还原勾选的产品吗','recovery')" href="javascript:;"><i class="Hui-iconfont">&#xe66b;</i>还原</a>
        </span>
        <div class="text-c" align="right" style="float:  right;">


            <span class="select-box inline" style=" width:80px;"data-toggle="tooltip" data-placement="bottom" title="上下架">
		   <select class="select" name="parent_id" size="1">
                <option value="0">全部</option>
                   <option    value="1">上架</option>
                    <option    value="1">下架</option>
           </select>
		</span>
            <input type="text" placeholder="请输入 关键词"  class="input-text ac_input" name="search_text" value="" id="search_text" autocomplete="off" style="width:200px"><a  class="btn btn-default" id="search_button" onclick="product_search('图书搜索','/admin/product_search?keyword='+$('#search_text').val())"><i class="Hui-iconfont">&#xe709;</i></a>
        </div>
    </div>
    <!--<div class="cl pd-5 bg-1 bk-gray mt-20">-->
    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c" >
                <th width="15"><input type="checkbox" name="chkall"  id="chkall" value="0"></th>
                <th width="30" >编号</th>
                <th style="text-align:left;">商品名称</th>
                <th width="20%">分类</th>
                <th width="8%">售价</th>
                <th width="8%">库存</th>


                <th width="10%">操作</th>
            </tr>
            </thead>
            <tbody>
            <form action method="post" name="goodForm">
            @foreach( $products as $product)
            <tr class="text-c" >
                <td width="15"><input type="checkbox" name="ids[]"  id="checkbox" value="{{$product->id}}"></td>
                <td  >{{$product->id}}</td>
                <td style="text-align:left;">
                    <div style = "   width: 50px;height:50px;float:left; border:1px solid #e2e2e2; border-radius:5px;  display:table-cell;  vertical-align:middle;text-align:center;">
                        <img  src=" {{url($product->preview)}}" style=" width:40px; height:40px;"  >
                    </div>
                    <p style=" margin-top:10px; margin-left:10px; width:70%;">{{$product->name}}</p>
                </td>
                <td >
                    @foreach($product->category as $cate )
                        [{{$cate->name}}]&nbsp;
                    @endforeach</td>
                <td >{{$product->price}} </td>
                <td >{{$product->num}} </td>


                <td class="f-14 td-manage">

                    <a style="text-decoration:none" class="ml-5"
                           onClick="checkbox('确定要彻底删除此条产品吗','delete',{{$product->id}})"
                            href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe60b;</i>
                    </a>
                </td>
            </tr>
            @endforeach
            </form>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">
    /**
     * 多选框批量删除
     * @return
     */
    function checkbox(title,select,id){
        var idArray = [];
        if($('input:checkbox[name="ids[]"]:checked').length>0) {
            $('input:checkbox[name="ids[]"]:checked').each(function (i) {
                idArray.push(this.value);
            });
        }else if(id){
            idArray.push(id);
        }else {
            layer.msg('请勾选商品', {icon: 2, time: 2000});
            return;
        }

        layer.confirm(title,function(index){
            if($('input:checkbox[name="ids[]"]:checked').length>0) {
                var idArray = [];
                var idString = '';
                $('input:checkbox[name="ids[]"]:checked').each(function (i) {
                    idArray.push(this.value);
                });
            }
            $.ajax({
                type: 'post',
                url: '/admin/service/product/del', // 需要提交的 url
                dataType:'json',
                data: {
                    select:select,
                    idArray: idArray,
                    _token: "{{csrf_token()}}"
                },
                success: function (data) {
                    if (data == null) {
                        layer.msg('服务端错误', {icon: 2, time: 2000});
                        return;
                    }
                    if (data.status != 0) {
                        layer.msg(data.message, {icon: 2, time: 2000});
                        return;
                    }
                    layer.msg(data.message, {icon: 1, time: 2000});
                    location.replace(location.href);
                },
                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon: 2, time: 2000});
                },
                // beforeSend: function(xhr){
                //   layer.load(0, {shade: false});
                // },
            });
        });
    }
    /*-删除*/
    function product_del(obj,id){
        layer.confirm('确认要删除类别： '+ obj +' 吗？',function(index){
            $.ajax({
                type: 'post',
                url: '/admin/service/product/del', // 需要提交的 url
                dataType: 'json',
                data: {
                    product_id :id,
                    _token: "{{csrf_token()}}"
                },
                success: function(data) {
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
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:2000});
                },
               // beforeSend: function(xhr){
                 //   layer.load(0, {shade: false});
               // },
            });
        });
    }


</script>

@endsection