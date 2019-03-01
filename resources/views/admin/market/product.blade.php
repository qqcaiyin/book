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
    .pagelist{
        width:300px;
        float: right;
        color:#888888; padding:0px 5px; text-align:center; font-size:16px; font-family:"宋体";
    }

    .pagelist a{
        height:28px; line-height:28px; overflow:hidden; color:#666666; font-size:15px; text-align:center; display:inline-block; padding:0 12px; margin:0 4px;  -webkit-border-radius:2px; -moz-border-radius:2px; border-radius:2px; border:1px solid #ddd;
    }

    .pagelist a:hover, .pagelist a.cur{
        color:#FFF; background-color:#007cc3;
    }

    .pagelist a.p_pre:hover{
        background-color:#eaeaea; color:#555555;
    }
    .pagelist ul li{ float:left;   border:none; }
    .pagelist span{
        height:28px; line-height:28px; overflow:hidden; color:#666666; font-size:16px; text-align:center; display:inline-block; padding:0 12px; margin:0 4px;  -webkit-border-radius:2px; -moz-border-radius:2px; border-radius:2px;
    }
    .pagelist ul li a.active {color:#FFF; background-color:#007cc3; }


</style>

@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 选择商品 </nav>
<div class="page-container">
    <div style=" width: 100%;  display: inline-block; margin-top: 2px;" >
        <div  style="float: left; ; ">
        <form method="get" action="">
        <span class="select-box inline" style=" width:200px;" data-toggle="tooltip" data-placement="bottom" title="按类别">
		   <select class="select" name=" category_id" size="1">
                <option value="0">所有分类</option>
               @foreach($cate as $c)
                   <option   @if(isset($products->search['category_id'])&&$products->search['category_id'] == $c->id) selected @endif value="{{$c->id}}">{{$c->name}}</option>

               @endforeach
           </select>
		</span>
            <input type="text" style="display: none;" name="is_search" value="1">
            <input type="text" placeholder="请输入 关键 词"  class="input-text ac_input" name="keywords"
                   value="@if(isset($products->search['keywords'])&&$products->search['keywords']!='') {{$products->search['keywords']}} @endif"
                   id="search_text" autocomplete="off" style="width:100px"><input  type="submit" class="btn btn-success"  value="搜索">
        </form>
        </div>
        <div class="pagelist" >
            <ul>
                @if($products->lastpage() > 1)
                        <li><a href="{{$products->previousPageUrl()}}">上一页</a></li>
                        <li><a href="{{$products->nextPageUrl()}}">下一页</a></li>
                @endif
            </ul>
            <span style="padding-bottom: 3px;">
                <input type="text"  style=" display: inline-block; height:28px; width:40px;   border:1px solid  #ddd; border-radius: 3px;   "  value="  {{$products->currentPage()}}" onchange="toPage(this )"    data-max="{{$products->lastpage()}}" >
                / {{$products->lastPage()}}
            </span>
        </div>
    </div>
    <!--<div class="cl pd-5 bg-1 bk-gray mt-20">-->
    <div class="mt-20" style=" min-height: 400px; max-height: 400px; margin-top:5px;">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c" >
                <th width="15"><input type="checkbox" name="chkall"  id="chkall" value="0"></th>
                <th width="40" >编号</th>
                <th style="text-align:left;">名称</th>
                <th width="8%">售价</th>

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

                <td ><input type="text"  class="input-mi"  style=" text-align: center; width:100px;"    onchange="_change(this,'price',{{$product->id}})"  value="{{$product->price}}" ></td>
            </tr>
            @endforeach
            </form>
            </tbody>
        </table>
    </div>
    <div style="height:50px; width:100%;  text-align: center;">
        <span style=" display: inline-block; height:30px; width:80px; border:1px solid #007cc3; text-align: center; vertical-align: middle;  line-height: 30px; border-radius: 4px;cursor: pointer; "  onclick="selectPdt();" >提交</span>
        <span style=" display: inline-block;  margin-left:50px  ;height:30px; width:80px; border:1px solid #007cc3; text-align: center; vertical-align: middle;  line-height: 30px; border-radius: 4px; cursor: pointer;"  onclick=" layer_close();" >返回</span>

    </div>
</div>
@endsection
@section('my-js')
<script type="text/javascript">


  $(function(){
        var v =$(window.parent.document).find("#good_ids").val();
        var arr =v.split(',');

       $('input:checkbox[name="ids[]"]').each(function (i) {
           if($.inArray($(this).val(),arr) != -1 ){
               $(this).prop('checked','checked');
           }
       });

    });

  //提交
  function  selectPdt(){
      if($('input:checkbox[name="ids[]"]:checked').length>0) {
          var idArr= [];
          var  ids='' ;
          $('input:checkbox[name="ids[]"]:checked').each(function (i) {
              idArr.push(this.value);
              ids +=(this.value)+',';
          });

          var num =idArr.length;
          ids = ids.substring(0, ids.length - 1);//去掉最后面的','号
          $(window.parent.document).find("#num").html(num);//更新父页面选中产品数量
          $(window.parent.document).find("#good_ids").val(ids);
          layer_close();
      }else{
          layer.msg('选择抢购产品', {time:2000});
          return ;
      }
  }


  //跳转页面
   function toPage(t){

       var page = parseInt($.trim($(t).val()));
       page = isNaN(page)? 1: page;
       var  max = $(t).data('max');
       if(page <1 ){
           page =1 ;
       }
       if(page > max){
           page = max ;
       }
       $(t).val(page);

       location.href="/admin/pdt?page="+page;
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