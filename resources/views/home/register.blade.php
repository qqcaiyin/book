<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="https://cdn.staticfile.org/ionicons/2.0.1/css/ionicons.min.css">

    <title>欢迎注册会员</title>

<style>

    .main-box{
        width:1000px;
        border:1px solid #ddd ;
        padding-bottom: 112px;
        background-color: #fff;
        margin:60px auto 90px;
        overflow: hidden;
    }
    .reg-left{
        float:left;
        width:65%;

    }
    .form-box{
        padding:0;
        width:400px;
        margin: 55px 0 0 75px;

    }

  .input-box{
      overflow: visible;
      width:100%;
      height:50px;
      margin-top: 22px;
      padding: 0;
      position: relative;
      border:1px solid #dedede;
  }

    .reg_user{
        left:0;
        width:300px;
        height:48px;
        padding-left: 17%;
        padding-right: 3%;
        //position: absolute;
        display:block;
        border:none;
        float:right;
        outline: none;
    }

    .Validform-check{
        float: left;
        left:100%;
        width: 300px;
        display: inline-block;
        font-size: 12px;
        color:#888;
        margin-left: 8px;
        line-height: 20px;
        padding-left: 0px;
        position: relative;
        top:-40px;
    }
   /* .Validform-check label{
        color:red;
    }
    */

    .yzm-box{
        opacity:0.5;
        pointer-events:none;
    }
    .yzm{
        float:right;
        width:100px;
        height:100%;

    }
    .reg-right{
        top:0;
        right:0;
        width:240px;
       height: 200px;
        border-left: 1px solid #ddd;
        float: right;
        position: relative;
        padding-left: 14px;
    }
    .icon-den{
        color:#ddd;
    }
    .icon-den label{
        color:#ddd;
    }
    .icon-err{
        color:red;
    }
    .icon-err label{
        color:red;
    }

    .icon-suc{
        color:green;
    }
 </style>

</head>
<body>

<!--Begin Header Begin-->
<div class="soubg"style="border: 1px solid #ebebeb; height:80px;">
    <div class="sou" style=" height:100%;vertical-align: bottom;">
        <span class="fr" style="margin-top: 42px;">
        	<span class="fl">我已经注册, 马上</span>
            <span class="fr">&nbsp;<a href="{{url('/login')}}" style="color:#185bc9; ">登录 &gt; </a></span>
        </span>
    </div>
</div>
<!--End Header End-->

<!--Begin 主框 Begin-->
<div style=" width:1200px; margin: 0 auto; ">
    <div   class ="main-box"  >
        <div class="reg-left">
            <div class="form-box">
                <form method="post">
                    <div class="input-box">
                        <label  for="username"  class="icon-user"></label>
                        <input  class="reg_user" type="text" name="username" id="username"   value=""  placeholder="用户名"  maxlength="20" autocomplete="off"  />
                        <div class="Validform-check">
                            <span class="i-tip ion-alert icon-den"><i class="" ></i><label style="margin-left: 5px;"> 支持中文、字母、数字、“-”“_”的组合</label></span>
                        </div>
                    </div>
                    <div class="input-box">
                        <label  for="username"  class="icon-phone"></label>
                        <input  class="reg_user" type="text" name="moble" id="moble"   value=""  placeholder="手机号码" minlength="11"  maxlength="11" autocomplete="off"  />
                        <div class="Validform-check">
                            <span class="i-tip "><i ></i><label style="margin-left: 5px;"> </label></span>
                        </div>
                    </div>
                    <div class="input-box yzm-box">
                        <label  for="username"  class="icon-yzm"></label>
                        <input type="button"  class="log_btn  yzm " id="sendcode" value="获取验证码" />
                        <input  class="reg_user" type="text" name="smscode" id="smscode"    value=""  placeholder="请输入短信验证码" minlength=""  maxlength="11" autocomplete="off"   style=" width:200px;" />
                        <div class="Validform-check">
                            <span class="i-tip"><i class=""></i><label style="margin-left: 5px;"> </label></span>
                        </div>
                    </div>

                    <div class="input-box">
                        <label  for="username"  class="icon-setpwd"></label>
                        <input  class="reg_user" type="password" name="password" id="password"   value=""  placeholder="请输入密码"   minlength="6" maxlength="20" autocomplete="off"  />
                        <div class="Validform-check">
                            <span class="i-tip ion-alert icon-den"><i class=""></i><label style="margin-left: 5px;"> 字母、数字和符号两种及以上的组合，6-20字符</label></span>
                        </div>
                    </div>
                    <div class="input-box">
                        <label  for="username"  class="icon-setpwd"></label>
                        <input  class="reg_user" type="password" name="repassword" id="repassword"  value=""  placeholder="请再次输入密码"   minlength="6" maxlength="20" autocomplete="off"  />
                        <div class="Validform-check">
                            <span class="i-tip"><i class=""></i><label style="margin-left: 5px;"> </label></span>
                        </div>
                    </div>
                    <div class="input-box" style="border:none;">
                    	   <input type="checkbox" name="agree" id="agree" value="1" />
                        <label for="agree">我已阅读并接受</label><a href="javascript:;"  onclick="rule('/reg/rule')"style="color:#185bc9; ">《用户协议》 </a>
                        <div class="Validform-check" style=" top:-20px;">
                            <span class="i-tip"><i class=""></i><label style="margin-left: 5px;"> </label></span>
                        </div>
                    </div>
                    <div class="input-box">
                        <input type="button"  class="reg_btn" id="reg" value="立即注册" />
                    </div>
                </form>
            </div>
        </div>
        <div class="reg-right">
            <div style="margin-top: 80px; ">
                <span> 其他账号登陆</span>
            </div>
        </div>
    </div>
</div>

<!--End Login End-->
<!--Begin Footer Begin-->
<div class="btmbg">
    <div class="btm">
        <a href="/" target="_blank">首页</a>| <a href="/n-about.html" target="_blank">关于我们</a>
        | <a href="/n-help.html" target="_blank">联系我们</a>
        | <a href="/n-help.html" target="_blank">帮助中心</a>
    </div>
    <div class="btm">
        <br />Copyright © 2015-2018  All Rights Reserved.  <br />
    </div>
</div>
<!--End Footer End -->

</body>
<!--[if IE 6]>
<script src="/home/js/iepng.js" type="text/javascript"></script>
<script type="text/javascript">
    EvPNG.fix('div, ul, img, li, input, a');
</script>
<![endif]-->

<<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>


<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.form.js"></script>
<script type="text/javascript" src="/admin/js/uploadFile.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<script >

    function rule(url){
        layer_show('',url,1000,600);
    }

    $(function () {
        //注册处理
        var username = $('#username'),
            moble = $('#moble'),
            smscode = $('#smscode'),
            password = $('#password'),
            repassword = $('#repassword'),
            agree = $('#agree');
        var enable = true;

        username.change(function(){
            checkUserName(false);

        });
        moble.change(function(){
            checkMoble(false);
        });
        password.change(function(){
            checkPwd(false);
        });
        repassword.change(function(){
            checkRePwd(false);
        });

        agree.click(function(){
            checkAgree();
        });



    //验证用户名
    function checkUserName(issubmit) {
        var isValid = false;
        var val = $.trim(username.val());   //去空格
        var i = username.siblings('.Validform-check').children();

        if (val == '') {
            if (issubmit) {
                i.attr('class', 'ion-minus-circled icon-err').children('label').text('请输入用户名');
            } else {
                i.attr('class', 'ion-alert icon-den').children('label').text('支持中文、字母、数字、“-”“_”的组合');
            }
        }else if (val.length < 4) {
            i.attr('class','ion-minus-circled icon-err').children('label').text('长度只能4-20个字符之间');
        }else if(/^[0-9]+$/.test(val)){
            i.attr('class','ion-minus-circled icon-err').children('label').text('用户名不能是纯数字');
        }else if (!/^[A-Za-z0-9_\-\u4e00-\u9fa5]+$/.test(val)) {
            i.attr('class','ion-minus-circled icon-err').children('label').text('请使用中文、字母、数字、“-”“_”的组合');
        }else{
            i.attr('class',"ion-checkmark-circled icon-suc").children("label").text('');
            isValid = true;
        }
        return  isValid;
    }

    //验证手机号
    function checkMoble(issubmit) {
        var isValid = false;
        var val = $.trim(moble.val());   //去空格
        var i = moble.siblings('.Validform-check').children();

        if (val == '') {
            if (issubmit) {
                i.attr('class', 'ion-minus-circled icon-err').children('label').text('请输入手机号码');
            }else{
                i.attr('class', '').children('label').text('');
            }
        }else if(!is_mobile(val)){

            i.attr('class','ion-minus-circled icon-err').children('label').text('手机号码格式不正确');
        }else{

            $.get(  '/service/reg' , {act:'check_moble',moble:val },function(data){
                if(data.status == 0){
                    //表示表里不存在,可以注册
                    i.attr('class',"ion-checkmark-circled icon-suc").children("label").text('');
                    //发送验证码功能解禁
                    $('#sendcode').parent().removeClass('yzm-box');
                  //  $('#smscode').attr('disabled',false).css('background-color','#fff');

                    isValid = true;
                }else if(data.status == 10){
                    //会员表里已存在
                    i.attr('class','ion-minus-circled icon-err').children('label').text('本手机号已注册，可直接登陆');
                    isValid = false;
                }
            },'json');

            isValid = true;
        }

        return isValid;

     }
        //验证密码
        function checkPwd(issubmit) {
            var isValid = false;
            var val = $.trim(password.val());
            var u = $.trim(username.val());
            var i = password.siblings('.Validform-check').children();
            if (val == '') {
                if (issubmit) {
                    i.attr('class', 'ion-minus-circled icon-err').children('label').text('请输入密码');
                } else {
                    i.attr('class', 'ion-alert icon-den').children('label').text('字母、数字和符号两种及以上的组合，6-20字符');
                }
            }else if(val.length < 6){
                i.attr('class', 'ion-minus-circled icon-err').children('label').text('长度在6-20个字符之间');
            }else if(val == u){
                i.attr('class', 'ion-minus-circled icon-err').children('label').text('密码和用户名相似，有盗号风险');
            }else{
                if( $.trim(repassword.val()) !='' && val != $.trim(repassword.val()) ){
                    repassword.siblings('.Validfom-check').children().attr('class', 'ion-minus-circled icon-err').children('label').text('两次密码不一致');
                }
                i.attr('class',"ion-checkmark-circled icon-suc").children("label").text('');
                isValid = true;
            }
            return isValid;

        }

        //验证密码
        function checkRePwd(issubmit){
            var isValid = false;
            var val1 = $.trim(repassword.val());
            var val2 = $.trim(password.val());
            var i = repassword.siblings('.Validform-check').children();
            if (val1 == '') {
                if (issubmit) {
                    i.attr('class', 'ion-minus-circled icon-err').children('label').text('请输入密码');
                } else {
                    i.attr('class', 'ion-alert icon-den').children('label').text('');
                }
            }else if( val1 != val2){
                i.attr('class', 'ion-minus-circled icon-err').children('label').text('两次密码不一致');
            }else{
                i.attr('class','ion-checkmark-circled icon-suc').children('label').text('');
                isValid = true;
            }
            return isValid;
        }

        //勾选 用户协议
        function checkAgree(){

            if(agree.prop('checked') == false){
                agree.siblings('.Validform-check').children().attr('class','ion-minus-circled icon-err').children('label').text('请同意协议并勾选');

                return 0;
            }else{
               agree.siblings('.Validform-check').children().attr('class','').children('label').text('');
                return 1;
            }
        }

    function checkSmscode() {
        var val = $.trim(smscode.val());
        var i = smscode.siblings('.Validform-check').children();
        if (val == '' || val.length != 6) {
            i.attr('class', 'ion-minus-circled icon-err').children('label').text('请填写手机验证码');
            return false;
        }
        else {
            i.attr('class', '').children('label').text('');
            return true;
        }

    }

/****begin****用户注册******begin*******/
        $('#reg').click(function(){
            if( !checkUserName(true) || !checkMoble(true) || !checkSmscode() || !checkPwd(true) || !checkRePwd(true) || !checkAgree()){
                return;
            }

            $.ajax({
                type: 'post',
                url:  '/service/reg',
                dataType: 'json',
                data:{
                    act: 'reg',
                    username: $.trim(username.val()),
                    tel: $.trim(moble.val()),
                    smscode: $.trim(smscode.val()),
                    password: $.trim(password.val()),
                    repassword: $.trim(repassword.val()),
                    agree : $('#agree:checked').val(),
                    _token: '{{csrf_token()}}'
                },
                success:function(data){
                    if(data.status == 0){
                        layer.msg('注册成功，欢迎您的加入!', {time:2000});
                        location.href='/login';
                        return ;
                    }else{
                        layer.msg('注册失败，稍后再试', {time:2000});
                        return ;
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('注册失败，稍后再试', {time:2000});

                },
            });
        })
/*****end*****用户注册*****end*****/
        //发送验证码
        $('#sendcode').click(function(){
            //time 过60秒才能再次点击发送
            if(enable == false){
                return ;
            }
            layer.msg('发送成功', { time:2000});
            enable =false;
            var num =60;
            var interval = window.setInterval(function(){
                $('#sendcode').val( '重新发送(' +(--num)+')');
                if(num == 0){
                    $('#sendcode').removeClass('ba_summary');
                    $('#sendcode').addClass('bk_important');
                    enable = true;
                    window.clearInterval(interval);
                    $('#sendcode').val('重新发送');
                }
            },1000);
            var v = $.trim(moble.val());
            if(v ==''){
                layer.msg('请填写手机号', {icon:1, time:2000});
                return ;
            }
            $('#smscode').val('');//清除
            $.get('/service/reg' , {act:'send_sms',moble:v },function(data){
                if(data.status == 0){
                    //发送成功 //60秒内不能再发送验证码
                  //  layer.msg('发送成功', { time:2000});
                    return  true;
                }else {
                    return    false;
                }
            },'json');
        });



    });





    //出发发送验证码
 /*   $('#sendcode').change(function(){
        var moble = $.trim( $('#moble').val() );

        if(moble.length == 11 && is_mobile(moble)){
             if(check_moble(moble)){

             }
        }

    });

*/
    //检测手机是否存在
    function check_moble(moble){
        $.get(  '/service/reg' , {act:'check_moble',moble:moble },function(data){
            if(data.status == 0){
                return  true; //表示表里不存在
            }else if(data.status == 10){
                return    false;
            }
        },'json');

    }
    //验证当前手机



    //英文字母
    function is_en(v) {
        return /^[A-Za-z]+$/.test(v);
    }

    //英文字母和数字 6到20位
    function is_enAndnum(v) {
        return /^[A-Za-z0-9]{6,20}$/.test(v);
    }

    //手机号码
    function is_mobile(v) {
        return /^(13|14|15|16|17|18)[0-9]{9}$/.test(v);
    }

    //email
    function is_email(v) {
        return /^(\w-*\.*)+@(\w-?)+(\.\w{2,10})+$/.test(v);
    }

    //固定电话
    function is_tel(v) {
        return /^[0-9]{1,4}(-|[0-9])\d{5,15}$/.test(v);
    }

    //中文
    function is_chinese(v) {
        return /^([\u4e00-\u9fa5])([\u4e00-\u9fa5·]){0,23}([\u4e00-\u9fa5])$/i.test(v);
    }

    function is_consignee(v) {
        return /^(([\u4e00-\u9fa5])([\u4e00-\u9fa5·]){0,10}([\u4e00-\u9fa5]))|([a-zA-Z]([a-zA-Z]|\s){2,20})$/i.test(v);
    }




</script>


</html>
