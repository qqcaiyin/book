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
        width:300px;
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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 系统 <span class="c-gray en">/</span> 配送管理 <span class="c-gray en">/</span> 配送方式 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5  mt-20" >
        <span class="l">
            <a class="btn btn-primary radius" onclick="layer_product('产品管理/添加产品','/admin/product_add')" href="javascript:;"><i class="Hui-iconfont">&#xe604;</i> 添加配送方式</a>
         <a class="btn btn-primary radius" onclick="checkbox_del(' > 删除','/admin/product_add')" href="javascript:;"><i class="Hui-iconfont">&#xe60b;</i>删除</a>
            <a class="btn btn-primary radius" href="{{ url('admin/product/recycle') }}"><i class="Hui-iconfont">&#xe609;</i>回收站</a>
        </span>

        </div>
        <!--<div class="cl pd-5 bg-1 bk-gray mt-20">-->
        <div class="mt-20">
            <table class="table table-border table-hover table-bg table-sort table1">
                <thead>
                <tr class="text-c" >
                    <th width="15"><input type="checkbox" name="chkall"  id="chkall" value="0"></th>

                    <th style="text-align:left;">配送方式</th>
                    <th width="20%">物流保价</th>
                    <th width="8%">启用</th>
                    <th width="8%">排序</th>
                    <th width="5%">操作</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-c">
                    <td width="15"><input type="checkbox" name="chkall"  id="chkall" value="0"></td>
                    <td style="text-align:left;">配送方式</td>
                    <td>物流保价</td>
                    <td class="td-status">
                            <span class="label label-defaunt radius" onclick="_change(this,'is_show',)">否</span>
                    </td>
                    <td >
                        <input type="text" class="input-mi" style=" border: solid  1px #e2e2e2;text-align: center; width:40px; height:25px;text-align:center;display:inline;" onchange="_change(this,'order',)"  value="" data-toggle="tooltip" data-placement="bottom" title="0~99">
                    </td>
                    <td > <a style="text-decoration:none" class="ml-5"
                             onClick="layer_product(
                                     '产品/产品列表/产品编辑',
                                     '/admin/product_edit/?id='
                                     )"
                             href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
                        </a>

                        <a style="text-decoration:none" class="ml-5"
                           href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe60b;</i>
                        </a></td>
                </tr>
                </tbody>
            </table>
            <div class="page_list"  align=" right" >
                {!!$products->render()!!}
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script type="text/javascript">

        function layer_product(title,url,id){
            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }
        /**
         * tp:   name  更改产品名
         *       price 更改价格
         *       num   更改库存
         *       order 更改排序
         * obj   this
         * id          类别编号
         */
        function  _change(obj,tp,id){
            var changeValue = $(obj).val();
            $.ajax({
                type: 'post',
                url: '/admin/service/product/changevalue', // 需要提交的 url
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
                    if(data.status != 0) {
                        layer.msg(data.message, {icon:2, time:3000});
                        return;
                    }
                    layer.msg(data.message, {icon:1, time:3000});
                    // location.replace(location.href);
                    // location.href='category?page='+data.pagenum;
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
         * 多选框批量删除
         * @return
         */
        function checkbox_del(title,url){
            if($('input:checkbox[name="ids[]"]:checked').length>0) {
                var idArray = [];
                var idString = '';
                $('input:checkbox[name="ids[]"]:checked').each(function (i) {
                    idArray.push(this.value);
                });
            }else{
                layer.msg('勾选要删除的商品', {icon: 2, time: 2000});
                return;
            }
            layer.confirm('确定要删除勾选的商品吗？',function(index){
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
                        select:"torecycle",
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
            var idArray = [];
            idArray.push(id);
            layer.confirm('确认要删除类别： '+ obj +' 吗？',function(index){
                $.ajax({
                    type: 'post',
                    url: '/admin/service/product/del', // 需要提交的 url
                    dataType: 'json',
                    data: {
                        select:"torecycle",
                        idArray :idArray,
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
                });
            });
        }


    </script>

@endsection