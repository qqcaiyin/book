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
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 产品 <span class="c-gray en">/</span> 产品类型管理 <span class="c-gray en">/</span> 类型添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class="page-container">

        <form class="form form-horizontal" id="form-type-add" name="form-type-add"  onsubmit="check()" method="post">
            {{csrf_field()}}
            <div style="margin-left: 12px;" >
                <label >类型名称：</label>
                <div style="display:inline;"  >
                    <input type="text" class="input-text"  autocomplete="off"   style="width: 500px;"  placeholder="" name="type_name" datatype="*" nullmsg="名称不能为空">
                   <span style="color:#d7d7d7; margin-left: 12px;"> 商品类型：例如手机、笔记本等</span>
                </div>
            </div>
            <div class="cl pd-5  mt-20" >
        <span class="l">
            <a class="btn btn-primary radius add" href="javascript:;"><i class="Hui-iconfont">&#xe604;</i> 添加扩展属性</a>
        </span>
            </div>
            <div class="mt-20">
                <table class="table table-border table-hover table-bg table-sort table1">
                    <thead>
                    <tr class="text-c">
                        <th width="20%" >属性名</th>
                        <th width="10%">展示类型</th>
                        <th >选择项数据【每项数据之间用逗号','做分割】</th>
                        <th width="10%">是否规格</th>
                        <th width="10%">操作</th>
                    </tr>
                    </thead>
                    <!-----------点击添加属性部分-----start------>
                    <tbody class="tbody">
                    <tr class="text-c trow" >
                        <td >
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 200px;"  placeholder="" name="attr_name[]" id="atte_name" style="text-align:left;"  >
                        </td>
                        <td >
                            <select class="select" name="uitype[]" size="1" style="width:150px; height:30px;">
                            <option value="0"> 单选框 </option>
                            <option value="1">复选框 </option>
                            <option value="2"> 输入框 </option>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="input-text"  autocomplete="off"   style="width: 600px;"  placeholder="" name="vallist[]" >
                        </td>
                        <td class="td-status">
                            <a  href="javascript:;"  class="label label-defaunt radius guige" >否</a>
                            <input type="hidden" name="is_guige[]" value="0">
                        </td>
                        <td class="f-14 td-manage">
                            <a title="删除" href="javascript:;"  class="ml-5 del" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        </td>
                    </tr>
                    </tbody>
                    <!-----------点击添加属性部分-  end---------->
                    <tr class="text-c trow newrow tp1 " style="display:none;">
                        <td >  <input type="text" class="input-text"  autocomplete="off"   style="width: 200px;"  placeholder="" name="attr_name[]" id="attr_name[]">
                        </td>
                        <td >
                            <select class="select" name="uitype[]" size="1" style="width:150px; height:30px;">
                                <option value="0"> 单选框 </option>
                                <option value="1">复选框 </option>
                                <option value="2"> 输入框 </option>
                            </select>
                        </td>
                        <td><input type="text" class="input-text"  autocomplete="off"   style="width: 600px;"  placeholder="" name="vallist[]" >
                        </td>
                        <td class="td-status">
                            <a  href="javascript:;"  class="label label-defaunt radius guige" >否</a>
                            <input type="hidden" name="is_guige[]" value="0">
                        </td>
                        <td class="f-14 td-manage">
                            <a title="删除" href="javascript:;" class="ml-5 del" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                        </td>
                    </tr>
                </table>
             <!--   <p><a href="javascript:void(0);" class="add"><i class="Hui-iconfont">&nbsp;&nbsp;&#xe604;</i>&nbsp; 再加一个</a></p>-->
            </div>
            <div  style=" margin-top: 12px;  " >
                <div >
                    <input class="btn btn-primary radius" type="submit"   value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    <input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;返回&nbsp;&nbsp;" onclick="window.location.href='/admin/type' ">
                </div>
            </div>
        </form>
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
         * 规格选择
         * @return
         */
        $('.guige').click(function(){
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
                        url: '/admin/service/type/add', // 需要提交的 url
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