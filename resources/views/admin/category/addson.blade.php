

@extends('admin.master')
@section('content')

    <div class="page-container">
        <form class="form form-horizontal" id="form-category-edit" method="post">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>类别：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text"  style=" width: 300px;"   id="name" name="name">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>编号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="number" class="input-text" style=" width: 300px;"  id = "category_no" name="category_no">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">前台显示：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <span class="select-box" style="width:300px;">
			            <select class="select" name="is_show" size="1" >
				            <option value="0">否</option>
                            <option value="1">是</option>
			            </select>
			        </span>
                </div>
            </div>
            <div class="row cl" >
                <label class="form-label col-xs-4 col-sm-3">logo：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                             <img id="preview_id" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" onclick="$('#input_id').click()" />
                                <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','','images', 'preview_id');" />
                    </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">简述：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="summary" cols="" rows="" class="textarea"  placeholder="类别简介...最少输入10个字符" onKeyUp="$.Huitextarealength(this,100)"></textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
                </div>
            </div>
            <div class="row cl" style=" margin-top: 20px;">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>
@endsection

@section('my-js')
<script type="text/javascript">

        $("#form-category-edit").validate({
            rules:{
                name:{
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
                    url: '/admin/service/category/add', // 需要提交的 url
                    dataType: 'json',
                    data: {
                        name: $('input[name=name]').val(),
                        category_no: $('input[name=category_no]').val(),
                        parent_id: "{{$category->id}}",
                        preview: ($('#preview_id').attr('src')!='/images/jia.png'?$('#preview_id').attr('src'):''),
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
                        parent.location.reload();
                    },
                    error: function(xhr, status, error) {

                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                        layer.msg('ajax error', {icon:2, time:2000});
                    },
                    beforeSend: function(xhr){
                        layer.load(0, {shade: false});
                    },
                });
            }
        });

</script>
@endsection