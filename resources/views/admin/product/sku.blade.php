@extends('admin.master')
<style>
    .table1 tr{
        border-collapse: collapse;
        border:1px solid #e2e2e2;
    }
    .table1 ,td{
        border:0px;
    }
    .add:link{
        text-decoration:none;
    }
</style>
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 产品 <span class="c-gray en">/</span> SKU <span class="c-gray en">/</span> 设置 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
@if($product->flag)
        <form class="form form-horizontal" id="form-type-add" name="form-type-add"  onsubmit="check()" method="post">
            {{csrf_field()}}
            <input type="hidden" name = "product_id" value="{{$product->id}}">
            <div style=" margin-left:12px;" >
                <label >产品信息：</label>
                <div style="display:inline; "  >
                    <span   style="color:black; margin-left: 12px; font-size: 22px;"> < {{$product->name}}  >| <p style=" font-size: 12px; display: inline">产品号：[{{$product->product_sn}}]</p> </span>
                </div>
            </div>
            <div class="cl pd-5  mt-20" >
                <span class="l">
                    <a class="btn btn-primary radius add" href="javascript:;"><i class="Hui-iconfont">&#xe604;</i> 添加SKU</a>
                </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-hover table-bg table-sort table1">
                    <thead>
                    <tr class="text-c">
                        @foreach($productSku as $value)
                        <th width="10%" >{{$value['name']}}</th>
                        @endforeach
                        <th width="40%" >简介</th>
                        <th width="10%">货号</th>
                        <th >价格</th>
                        <th width="10%">库存</th>
                        <th width="5%">操作</th>
                    </tr>
                    </thead>
                    <!-----------点击添加属性部分-----start------>
                    <tbody class="tbody">
                    @if($pdtSkus)
                        @foreach($pdtSkus as  $pdtSku)
                    <tr class="text-c trow" >
                        @foreach($productSku as $key=>$value)
                            <td >
                                <select class="select" name="sku_attr[]" size="1" style="width:150px; height:30px;">
                                    @foreach($value['value'] as $key=>$v)
                                        <option value="{{$key}}"  @if(in_array($key,$pdtSku->sku_attr)) selected @endif > {{$v}} </option>
                                    @endforeach
                                </select>
                            </td>
                        @endforeach
                        <td></td>
                        <td>
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 200px;" value="{{$pdtSku->sku_sn}}"   name="sku_sn[]" >
                        </td>
                        <td>
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 100px;"  value="{{$pdtSku->sku_price}}"  name="sku_price[]" >
                        </td>
                        <td class="td-status">
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 100px;"  value="{{$pdtSku->sku_num}}"  name="sku_num[]" >
                        </td>
                        <td class="f-14 td-manage">
                            <a title="删除" href="javascript:;"  class="ml-5 del" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        </td>
                    </tr>
                    @endforeach
                    @else
                        <tr class="text-c trow" >
                        @foreach($productSku as $key=>$value)
                            <td >
                                <select class="select" name="sku_attr[]" size="1" style="width:150px; height:30px;">
                                    @foreach($value['value'] as $key=>$v)
                                        <option value="{{$key}}"> {{$v}} </option>
                                    @endforeach
                                </select>
                            </td>
                        @endforeach
                        <td></td>
                        <td>
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 200px;"   name="sku_sn[]" >
                        </td>
                        <td>
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 100px;"   name="sku_price[]" >
                        </td>
                        <td class="td-status">
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 100px;"   name="sku_num[]" >
                        </td>
                        <td class="f-14 td-manage">
                            <a title="删除" href="javascript:;"  class="ml-5 del" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        </td>
                        </tr>
                    @endif
                    </tbody>
                    <!-----------点击添加属性部分-  end---------->

                    <tr class="text-c trow newrow tp1 " style="display:none;">
                        @foreach($productSku as $key=>$value)
                            <td >
                                <select class="select" name="sku_attr[]" size="1" style="width:150px; height:30px;">
                                    @foreach($value['value'] as $key=>$v)
                                        <option value="{{$key}}"> {{$v}} </option>
                                    @endforeach
                                </select>
                            </td>
                        @endforeach
                        <td></td>
                        <td>
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 200px;"   name="sku_sn[]" >
                        </td>
                        <td>
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 100px;"   name="sku_price[]" >
                        </td>
                        <td class="td-status">
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 100px;"   name="sku_num[]" >
                        </td>
                        <td class="f-14 td-manage">
                            <a title="删除" href="javascript:;"  class="ml-5 del" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        </td>
                    </tr>

                </table>
                <!--   <p><a href="javascript:void(0);" class="add"><i class="Hui-iconfont">&nbsp;&nbsp;&#xe604;</i>&nbsp; 再加一个</a></p>-->
            </div>
            <div  style=" margin-top: 12px;  " >
                <div >
                    <input class="btn btn-primary radius" type="submit"   value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    <input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;返回&nbsp;&nbsp;" onclick="location.href='/admin/product' ">
                </div>
            </div>
        </form>
@else
    <section class="container-fluid page-404 minWP text-c">
        <p class="error-title"><i class="Hui-iconfont va-m" style="font-size:80px">&#xe688;</i>
            <span class="va-m"> ...</span>
        </p>
        <p class="error-description">该产品规格还未设置，前往设置~</p>
        <p class="error-info">您可以：
            <a href="javascript:;" onclick="location.href='/admin/product'  " class="c-primary ml-20">< 返回</a>&nbsp;&nbsp;|
            <a href="javascript:;" onclick="location.href='/admin/product_edit/?id={{$product->id}}'  " class="c-primary ml-20">去编辑 &gt;</a>
        </p>
    </section>
@endif
</div>
@endsection

@section('my-js')
    <script type="text/javascript">
        function attr_edit(title,url,id,width,height){
            layer_show(title,url,width,height);
        }
        //点击删除属性框数目
        $('.del').click(function(){
            if($(this).parents('.trow').hasClass('newrow')){
                del($(this).parents('.trow').index());
            }
        });

        //点击增加属性框数目
        $('.add').click(function(){
            $('.tp1').clone(true).appendTo('.tbody').removeClass('tp1').removeAttr('style');
        });

        function del(i){
            $('.trow').eq(i).remove();
        }


        /**
         * 检查属性名框是否有重复的
         * @return
         */
        function check(){
            var arr = [];
            var flag = true;
            $("input[name='attr_name[]']").each(function () {
                if( $.trim( $(this).val() )!='' ){
                    if($.inArray($.trim( $(this).val()),arr)>=0){
                        layer.msg('属性名有重复', {icon:2, time:2000});
                        flag = false;
                        return  false;
                    }
                    arr.push($.trim( $(this).val()));
                }
            });
            return  flag;
        }

        /**
         * 提交表单
         * @return
         */
        $(function(){
            $("#form-type-add").validate({
                rules:{
                    attr_name:{
                        required:true,
                        minlength:2,
                        maxlength:16
                    },
                    category_no:{
                        required:true,
                    },
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type: 'post',
                        url: '/admin/service/product/sku/add', // 需要提交的 url
                        dataType: 'json',
                        data: {
                            // name: $('input[name=name]').val(),
                            //  category_no: $('input[name=category_no]').val(),
                            // parent_id: $('select[name=parent_id] option:selected').val(),
                            //  preview: ($('#preview_id').attr('src')!='/images/jia.jpg'?$('#preview_id').attr('src'):''),
                            _token:"{{csrf_token()}}"
                        },
                        success: function(data) {
                            if(data == null) {
                                layer.msg('服务端错误', {icon:2, time:2000});
                                return;
                            }
                            data.status=0;
                            if(data.status != 0) {
                                layer.msg(data.message, {icon:2, time:2000});
                                return;
                            }
                            layer.msg(data.message, {icon:1, time:2000});
                            self.location = document.referrer;
                            // window.history.go(-1);
                            //parent.location.reload();
                        },
                        error: function(xhr, status, error) {

                            console.log(xhr);
                            console.log(status);
                            console.log(error);
                            layer.msg('ajax error', {icon:2, time:2000});
                        },
                    });

                }
            });
        });
    </script>
@endsection