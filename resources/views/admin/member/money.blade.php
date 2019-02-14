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
width:200px;
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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 会员 <span class="c-gray en">/</span> 会员管理 <span class="c-gray en">/</span>资金调整 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

    <div class="page-container">
        <form action="" method="post" class="form form-horizontal" id="form-money-change">
            <input type="text" id="r1" name="id" style="display: none;" value="{{$member->id}}">
            {{csrf_field()}}
        <div class="cl pd-5  mt-20" >
            <label class="">余额：</label>
            <div class="radio-box">
                <input type="radio" id="r1" name="balance_type" checked value="1">
                <label for="r1">增加</label>
            </div>
            <div class="radio-box">
                <input type="radio" id="r2" name="balance_type" value="0">
                <label for="r2">减少</label>
            </div>
            <input type="text" name="balance"     class="input-mi"  style=" border:solid 1px #bbb;"   placeholder=" 填写金额"  autuocomplete="off" onkeyup="value=value.replace(/[^\d]/g,'')">
            <label class="">可用余额￥：{{$member->openbalance}}</label>
        </div>
        <div class="cl pd-5  mt-20" >
            <label class="">积分：</label>
            <div class="radio-box">
                <input type="radio" id="r1" name="point_type" checked value="1">
                <label for="r1">增加</label>
            </div>
            <div class="radio-box">
                <input type="radio" id="r2" name="point_type" value="0">
                <label for="r2">减少</label>
            </div>
            <input type="text" name="point"     class="input-mi"  style=" border:solid 1px #bbb;"   placeholder=" 填写积分" autuocomplete="off" onkeyup="value=value.replace(/[^\d]/g,'')">
            <label class="">可用积分：{{$member->point}}</label>
        </div>
        <div class="cl pd-5  mt-20" >
            <label class="">冻结资金￥：</label>
            <div class="radio-box">
                <input type="radio" id="r1" name="freeze_type" checked value="0">
                <label for="r1">冻结</label>
            </div>
            <div class="radio-box">
                <input type="radio" id="r2" name="freeze_type" value="1">
                <label for="r2">解冻</label>
            </div>
            <input type="text" name="freeze"     class="input-mi"  style=" border:solid 1px #bbb;"   placeholder=" 填写金额" autuocomplete="off" onkeyup="value=value.replace(/[^\d]/g,'')">
            <input type="text" name="pre_freeze"     style=" display: none;"  value = "{{$member->freeze}}">
            <label class="">已冻结资金：{{$member->freeze }}</label>
            <a class="label label-success "   href="javascript:;" id="freezall"> 全部冻结</a>
            <a class="label label-success "   href="javascript:;" id="unfreezall">全部解冻</a>
        </div>
        <div class="cl pd-5  mt-20" >
            <label class="">操作备注：</label>
            <input type="text" name="disc"     class="input-mi"  style=" border:solid 1px #bbb;width:500px;"   placeholder=" 填写备注" >
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
        </form>
    </div>

@endsection

@section('my-js')

    <script type="text/javascript">

        $(function(){
            $("#form-money-change").validate({
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
                onkeyup:false,
                //focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type:'post',
                        url:'/admin/service/member/adjust_balance',
                        dataType: 'json',
                        data:{
                            pre_money:'{{$member->money}}',
                            pre_openbalance:'{{$member->openbalance}}',
                            pre_point:'{{$member->point}}',
                            _token:"{{csrf_token()}}"
                        },
                        success: function(data) {
                         //   if(data.status ==11)
                          //  {
                          //      layer.msg(data.message, {icon:2, time:2000});
                          //      return ;
                           // }
                            if(data.status == 0){
                                layer.msg("添加成功", {icon:1, time:2000});
                                parent.location.reload();
                            }else{
                                layer.msg(data.message, {icon:2, time:2000});
                                return ;
                            }

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