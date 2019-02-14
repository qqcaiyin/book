@extends('admin.master')

@section('content')
<article class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-member-add">
        {{csrf_field()}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>头像：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <img id="preview_id" src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id').click()" />
                <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','img','images', 'preview_id');" />
                <input type="text"  name="avatar" id="img"  style="display: none;">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>用户名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="nickname" name="nickname">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>性别：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input name="sex" type="radio" id="sex-1" checked value="0">
                    <label for="sex-1">男</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="sex-2" name="sex" value="1">
                    <label for="sex-2">女</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>手机：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="phone" name="phone">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>邮箱：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" placeholder="@" name="email" id="email">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" value="" placeholder="" id="password" name="password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>确认密码：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="password" class="input-text" value="" placeholder="" id="confirm_password" name="confirm_password">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>真实姓名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder=""  name="truename">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>账户状态：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input type="radio"id="enable-1" name="enable" checked value="1">
                    <label for="enable-1">正常</label>
                </div>
                <div class="radio-box">
                    <input type="radio" id="enable-2" name="enable" value="0">
                    <label for="enable-2">冻结</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>
@endsection

@section('my-js')
<script type="text/javascript">
//校验
        $(function(){

            $("#form-member-add").validate({
                rules:{
                    nickname:{
                        required:true,
                        minlength:5,
                        maxlength:16
                    },
                    phone:{
                        required:true,
                        isMobile:true,
                    },
                    email:{
                        required:true,
                        email:true,
                    },
                    password:{
                        required:true,
                        minlength:6,
                    },
                    confirm_password:{
                        required:true,
                        minlength:6,
                    },
                    truename:{
                        required:true,
                        minlength:2,
                    },
                },
                messages:{
                    nickname: "请输入名字(5-16字)",
                },
                //onkeyup:false,
                //focusCleanup:true,
                success:"valid",

                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type:'post',
                        url:'/admin/service/member/add',
                        dataType: 'json',
                        data:{
                            //头像
                            _token:"{{csrf_token()}}"
                        },
                        success: function(data) {
                            if(data.status ==10)
                            {
                                layer.msg(data.message, {icon:2, time:2000});
                                return ;
                            }
                            layer.msg("添加成功", {icon:1, time:2000});
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