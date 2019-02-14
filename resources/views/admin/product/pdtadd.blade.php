

@extends('admin.master')
@section('content')

    <article class="page-container">
        <form class="form form-horizontal" id="form-product-add"  name="form-product-add"    method="post" action="{{url('/admin/service/product/add')}}" >
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品类别：</label>
                <div class="formControls col-xs-8 col-sm-9">
				        <span class="select-box">
				            <select name="category_id" class="select">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
				            </select>
				        </span>
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>商品名称：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input type="text" class="input-text" value="" placeholder=""  name="name">
                    </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">关键词：</label>
                <div class="formControls col-xs-8 col-sm-9"  >
                    <textarea cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100"   name="summary"></textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">简介：</label>
                    <div class="formControls col-xs-8 col-sm-9" >
                        <textarea cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100"   name="summary"></textarea>
                        <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
                    </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">价格：</label>
                    <div class="formControls col-xs-8 col-sm-9" style="width:200px;">
                        <input type="text" class="input-text" value="" placeholder=""  name="price">
                    </div>
                <label class="form-label col-xs-4 col-sm-2">折扣：</label>
                <div class="formControls col-xs-8 col-sm-9" style="width:200px;">
                    <input type="text" class="input-text" value="" placeholder=""  name="price">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">添加缩略图：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <img id="preview_id" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id').click()" />
                        <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','images', 'preview_id');" />
                    </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">文章内容：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/ueditor.all.min.js')}}"> </script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                        <script id="editor" name="content" type="text/plain" style="width:860px;height:300px;"></script>
                         <style>
                            .edui-default{line-height: 28px;}
                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                            {overflow: hidden; height:20px;}
                            div.edui-box{overflow: hidden; height:22px;}
                        </style>
                        <script type="text/javascript" >
                            var ue = UE.getEditor('editor');
                        </script>
                    </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">轮播图：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <img id="preview_id1" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id1').click()" />
                        <input type="file" name="file" id="input_id1" style="display: none;" onchange="return uploadImageToServer('input_id1','images', 'preview_id1');" />
                        <img id="preview_id2" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id2').click()" />
                        <input type="file" name="file" id="input_id2" style="display: none;" onchange="return uploadImageToServer('input_id2','images', 'preview_id2');" />
                        <img id="preview_id3" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id3').click()" />
                        <input type="file" name="file" id="input_id3" style="display: none;" onchange="return uploadImageToServer('input_id3','images', 'preview_id3');" />
                        <img id="preview_id4" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id4').click()" />
                        <input type="file" name="file" id="input_id4" style="display: none;" onchange="return uploadImageToServer('input_id4','images', 'preview_id4');" />
                    </div>
            </div>

            <div class="row cl" style=" margin-top: 20px;">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius"  type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection

@section('my-js')
<script type="text/javascript">
    $(function(){
        var ue = UE.getEditor('editor');
        ue.execCommand( "getlocaldata" );

        $("#form-product-add").validate({
            rules:{
                name:{
                    required:true,
                },
                pice:{
                    required:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",

            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: '/admin/service/product/add', // 需要提交的 url
                    dataType: 'json',
                    data: {
                        name: $('input[name=name]').val(),
                        summary: $('input[name=summary]').val(),
                        price: $('input[name=price]').val(),
                        category_id: $('select[name=category_id] option:selected').val(),
                        preview: ($('#preview_id1').attr('src')!="/images/jia.png"?$('#preview_id').attr('src'):''),
                        content: ue.getContent(),
                        //content:  $('input[name=content]').val(),
                        preview1: ($('#preview_id1').attr('src')!=='/images/jia.png'?$('#preview_id1').attr('src'):''),
                        preview2: ($('#preview_id2').attr('src')!='/images/jia.png'?$('#preview_id2').attr('src'):''),
                        preview3: ($('#preview_id3').attr('src')!='/images/jia.png'?$('#preview_id3').attr('src'):''),
                        preview4: ($('#preview_id4').attr('src')!='/images/jia.png'?$('#preview_id4').attr('src'):''),
                        _token:"{{csrf_token()}}"
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
                });

            }
        });
    });


</script>
@endsection