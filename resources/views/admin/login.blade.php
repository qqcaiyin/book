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
        border: 1px solid #bbb;
        background-color:white ;
        cursor: pointer;
        text-align: center;
        width:200px;
        height:25px;
        border-radius:5px;

    }
    .input-mi:focus{
        box-shadow: 0 0 15px  black;
    }
    .input-mi:hover{
     //background-color: red;
        border: #bbb 1px solid;
    }

    html, body{ height:100%}
    body{font-size:14px}

</style>
@section('content')
    <link rel="stylesheet" href="/admin/jq/demo/css/style.css" />
    <link href="/admin/static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css" />
    <!-- remember, jQuery is completely optional -->
    <!-- <script type='text/javascript' src='js/jquery-1.11.1.min.js'></script> -->
    <script type='text/javascript' src='/admin/jq/jquery.particleground.js'></script>
    <script type='text/javascript' src='/admin/jq/demo/js/demo.js'></script>


<div  id="particles">
    <div class="loginBox" >
        <div align="center" style =" margin-top: 20%;">
        <form class="form "  id="form-login" style="" action="" method="post">
           {{csrf_field()}}
            <div class="row cl">
                    <input id="" name="username" type="text" placeholder="  用户名 " class="input-mi"   autocomplete="off" >
            </div>
            <div class="row cl" >
                    <input type="password" name="password" style="display:none">
                    <input id="" name="password" type="password" placeholder= "  密&nbsp; 码 "  class="input-mi" autocomplete="off">
            </div>
            <div class="row cl" >
                    <input   style=" width: 200px;" type="submit" class="btn btn-success radius size-l" value="&nbsp;&nbsp;&nbsp;Enter&nbsp;&nbsp;&nbsp;">
            </div>
        </form>
        </div>
    </div>
</div>

@endsection

@section('my-js')
    <script type="text/javascript">
        $(function(){
            $("#form-login").validate({
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type:'post',
                        url:'/admin/login/check',
                        dataType: 'json',
                        data:{
                            _token:'{{csrf_token()}}'
                        },
                        success: function(data) {
                            console.log(data);
                            if(data.status != 0)
                            {
                                layer.msg(data.message,{icon:2, time:2000});
                                return ;
                            }
                            location.href='/admin/index';
                        },
                        error: function(xhr, status, error) {
                            layer.msg('ajax error', {icon:2, time:2000});
                        },
                    });

                }
            });
        });
    </script>

@endsection