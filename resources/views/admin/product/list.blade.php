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
    <nav class="breadcrumb" ><i class="Hui-iconfont">&#xe67f;</i> 产品 <span class="c-gray en">/</span> 产品管理 <span class="c-gray en">/</span> 产品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container" style="  padding-top: 0px;">
    <div class="cl pd-5  mt-20"  style=" margin-top:  0px;" >
        <span class="l">
            <a class="btn btn-primary radius"  onclick="layer_product('产品管理/添加产品','/admin/product_add')" href="javascript:;"><i class="Hui-iconfont">&#xe604;</i> 添加产品</a>
         <a class="btn btn-primary radius" onclick="checkbox_del(' > 删除','/admin/product_add')" href="javascript:;"><i class="Hui-iconfont">&#xe60b;</i>删除</a>
            <a class="btn btn-primary radius" href="{{ url('admin/product/recycle') }}"><i class="Hui-iconfont">&#xe609;</i>回收站</a>
        </span>
        <form method="get" action="">
        <div class="text-c" align="right" style="float:  right;">
        <span class="select-box inline" style=" width:170px;" data-toggle="tooltip" data-placement="bottom" title="按类别">
		   <select class="select" name="category_id" size="1">
                <option value="0">所有分类</option>
               @foreach($cate as $c)

                   <option   @if(isset($products->search['category_id'])&&$products->search['category_id'] == $c->id) selected @endif value="{{$c->id}}">{{$c->name}}</option>

               @endforeach
           </select>
		</span>
            <span class="select-box inline" style=" width:80px;"data-toggle="tooltip" data-placement="bottom" title="精品...">
		   <select class="select" name="search_tp1" size="1">
                <option value="3">全部</option>
                    <option value="0" @if(isset($products->search['search_tp1'])&&$products->search['search_tp1'] == 0) selected @endif  >新品</option>
                    <option value="1" @if(isset($products->search['search_tp1'])&&$products->search['search_tp1'] == 1) selected @endif>热销</option>
                    <option value="2" @if(isset($products->search['search_tp1'])&&$products->search['search_tp1'] == 2) selected @endif>精品</option>
           </select>
		</span>
            <span class="select-box inline" style=" width:80px;"data-toggle="tooltip" data-placement="bottom" title="上下架">
		   <select class="select" name="search_tp2" size="1">
                <option value="2">全部</option>
                   <option value="0" @if(isset($products->search['search_tp2'])&&$products->search['search_tp2'] == 0) selected @endif>下架</option>
                   <option value="1" @if(isset($products->search['search_tp2'])&&$products->search['search_tp2'] == 1) selected @endif>上架</option>
           </select>
		</span>
            <input type="text" style="display: none" name="is_search" value="1">
            <input type="text" placeholder="请输入 关键 词"  class="input-text ac_input" name="keywords"
                   value="@if(isset($products->search['keywords'])&&$products->search['keywords']!='') {{$products->search['keywords']}} @endif"
                   id="search_text" autocomplete="off" style="width:200px"><input  type="submit" class="btn btn-success" >
        </div>
        </form>
    </div>
    <!--<div class="cl pd-5 bg-1 bk-gray mt-20">-->
    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c" >
                <th width="15"><input type="checkbox" name="chkall"  id="chkall" value="0"></th>
                <th width="40" >编号</th>
                <th style="text-align:left;">名称</th>
                <th width="20%">产品类别</th>
                <th width="8%">售价</th>
                <th width="8%">库存</th>
                <th width="5%">上架</th>
                <th width="5%">排序</th>
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
                    <input type="text" class="input-mi" style=" margin-top:15px; margin-left:12px; width:70%;" onchange="_change(this,'name',{{$product->id}})"  value=" {{$product->name}}" >
                </td>
                <td >
                    @foreach($product->category as $cate )
                      [{{$cate->name}}]&nbsp;
                        @endforeach
                </td>
                <td ><input type="text"  class="input-mi"  style=" text-align: center; width:100px;" onchange="_change(this,'price',{{$product->id}})"  value="{{$product->price}}" ></td>
                <td ><input type="text"  class ="input-mi" style="  width:80px; height:25px;text-align:center;" onchange="_change(this,'num',{{$product->id}})"  value="{{$product->num}}" ></td>
                <td class="td-status">
                    @if($product->is_show == 0)
                        <span class="label label-defaunt radius" onclick="_change(this,'is_show',{{$product->id}})">否</span>
                    @else
                        <span class="label label-success radius" onclick="_change(this,'is_show',{{$product->id}})">是</span>
                    @endif
                </td>
                <td >
                    <input type="text" class="input-mi" style=" border: solid  1px #e2e2e2;text-align: center; width:40px; height:25px;text-align:center;display:inline;" onchange="_change(this,'order',{{$product->id}})"  value="{{$product->sort}}" data-toggle="tooltip" data-placement="bottom" title="0~99">
                </td>
                <td class="f-14 td-manage">
                    <a title="详情" href="javascript:;" onclick="layer_product('产品详情','/admin/product_info?id={{$product->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;</i></a>
                    <a style="text-decoration:none" class="ml-5"
                       onClick="layer_product(
                             '产品/产品列表/产品编辑',
                              '/admin/product_edit/?id={{$product->id}}'
                              )"
                       href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
                    </a>
                    <a style="text-decoration:none" class="ml-5"
                       onClick="layer_product(
                               '',
                               '/admin/product_sku/?id={{$product->id}}'
                               )"
                       href="javascript:;" title="sku"><i class="Hui-iconfont">&#xe681;</i>
                    </a>
                    <a style="text-decoration:none" class="ml-5"
                           onClick="product_del('{{$product->name}}',{{$product->id}})"
                            href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe60b;</i>
                    </a>
                </td>
            </tr>
            @endforeach
            </form>
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