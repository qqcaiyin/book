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
    label{display:inline-block;width:100px;text-align:right}
</style>
@section('content')
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 管理员 <span class="c-gray en">/</span> 管理员添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <form class="form form-horizontal" id="form-admin-add" name="form-product-add"    method="post" action="{{url('/admin/service/admin/add')}}" >
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    用户名：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text"  name="name"  id="website-Keywords" value="" class="input-text" style="width:300px;">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">
                    <span class="c-red">*</span>
                    密码：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="password"  name="password"   value="" class="input-text" style="width:300px;">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">角色选择：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    @foreach( $roles as $role)
                    <input name="role_id[]" type="checkbox"  value=" {{$role->id}}">{{$role->name}}&nbsp;&nbsp;
                    @endforeach
                </div>
            </div>

            <div class="row cl ">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                    <input class="btn btn-primary radius" type="submit"   value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                    <input class="btn btn-primary radius" type="button" value="&nbsp;&nbsp;返回&nbsp;&nbsp;" onclick="window.location.href='/admin/account/admin' ">
                </div>
            </div>
        </form>
	</div>
@endsection

@section('my-js')
	<script type="text/javascript">

        /**
         *表单验证
         * @return
         */
        $().ready(function() {
// 在键盘按下并释放及提交后验证提交表单
            $("#form-admin-add").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 2
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                },
                messages: {

                    username: {
                        required: "请输入用户名",
                        minlength: "用户名必需由两个字母组成"
                    },
                    password: {
                        required: "请输入密码",
                        minlength: "密码长度不能小于 6 个字母"
                    },

                }
            });
        });
	</script>
@endsection