<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />
    <link rel="stylesheet"  href="{{asset('css/weui.css')}}"  type="text/css">
    <link rel="stylesheet"  href="{{asset('css/book.css')}} "   type="text/css" >
    <title>欢迎登陆</title>
</head>
<body>
<!--Begin Header Begin-->
<div class="soubg"style="border: 1px solid #ebebeb; height:80px;">
    <div class="sou" style=" height:100%;vertical-align: bottom;">
        <span class="fr" style="margin-top: 42px;">
        	<span class="fl">您好！欢迎光临电商系统 !</span>
            <span class="fr">&nbsp;<a href="#" style="color:#185bc9; ">帮助中心&nbsp;</a></span>
        </span>
    </div>
</div>
<!--End Header End-->
<!--Begin Login Begin-->
<div class="log_bg">

    <div class="login">
        <div class="log_img"><img src="/images/login-pic.jpg" width="611" height="425" /></div>
        <div class="log_c" style="border:1px solid #0a6999; height:420px; width:400px" >
            <form method="post" action="">
                <table border="0" style="  font-size:14px; margin-top:30px; table-layout:fixed; " cellspacing="0" cellpadding="0">
                    <tr height="60" valign="top">

                        <td >
                            <span class="fl" style="font-size:24px;">登录</span>
                            <span class="fr">还没有商城账号，<a href="{{url('/register')}}" style="color:#007cc3;">立即注册</a></span>
                        </td>

                    </tr>
                    <tr height="60">

                        <td  >
                            <input type="text" name="username"  id="loginname" class="l_user" maxlength="20" datatype="*"  autocomplete="off"  placeholder='手机号码/Email' />
                        </td>
                    </tr>
                    <tr height="60">

                        <td  >
                            <input type="password"  name="pwd" style="display:none">
                            <input type="password"  name="pwd" id="pwd"   class="l_pwd" maxlength="20" minlength="6"  datatype="*" autocomplete="off" value placeholder="密码" />
                        </td>
                    </tr>
                    <tr height="60">

                        <td width="120px" >
                            <input type="text"  name="code" id="code" class="code-box"   minlength="4"  maxlength="4" autocomplete="off" value placeholder="验证码" />
                            <div class="weui_cell_ft" style="float: right;  border: 1px solid #000;width:110px;height:40px;">
                                <img  style=" width:100px;height:38px; border: 0px solid  #000;  margin-top: 2px;margin-right: 2px;" src="{{url('service/validate_code/create')}}" onclick="codeChange()" id="logincode"/>
                            </div>
                        </td>
                    </tr>
                    <tr>

                        <td height="30">
                            <span class="msg" style="color: red;"></span>
                        </td>
                    </tr>
                    <tr height="35">

                        <td style="font-size:12px; padding-top:20px;">
                	<span style="font-family:'宋体';" class="fl">
                    	<label class="r_rad"><input type="checkbox" name="autoLogin" id="autoLogin" /></label><label class="r_txt">自动登陆</label>
                    </span>
                            <span class="fr"><a href="#" >忘记密码</a></span>
                        </td>
                    </tr>
                    <tr height="50">

                        <td><input type="button"  onclick="onLoginClick();" value="登录" class="log_btn" /></td>
                    </tr>
                </table>
            </form>
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
<script src="//letskillie6.googlecode.com/svn/trunk/2/zh_CN.js"></script>
<![endif]-->
<script src="/home/js/iepng.js" type="text/javascript"></script>
<script type="text/javascript">
    EvPNG.fix('div, ul, img, li, input, a');
</script>

<script type="text/javascript" src="/home/js/jquery-1.11.1.min_044d0927.js"></script>
<script type="text/javascript" src="/home/js/jquery.bxslider_e88acd1b.js"></script>

<script type="text/javascript" src="{{asset('js/jquery-1.11.2.min.js')}}"></script>
<script type="text/javascript" src="/home/js/menu.js"></script>

<script type="text/javascript" src="/home/js/select.js"></script>

<script type="text/javascript" src="/home/js/lrscroll.js"></script>

<script type="text/javascript" src="/home/js/iban.js"></script>
<script type="text/javascript" src="/home/js/fban.js"></script>
<script type="text/javascript" src="/home/js/f_ban.js"></script>
<script type="text/javascript" src="/home/js/mban.js"></script>
<script type="text/javascript" src="/home/js/bban.js"></script>
<script type="text/javascript" src="/home/js/hban.js"></script>
<script type="text/javascript" src="/home/js/tban.js"></script>

<script type="text/javascript" src="js/lrscroll_1.js"></script>



<script type="text/javascript">

    //验证码点击刷新
    function codeChange(){
        $('#logincode').attr( 'src', '/service/validate_code/create?' + Math.random() );
    }

    //ajax登陆
    function onLoginClick() {
        var auto=0;
        var username = $('input[name=username]').val();
        var password = $('#pwd').val();
        var code = $('input[name=code]').val();
        if($('#autoLogin').is(':checked')){
            auto =1;
        }

        if(username == ''|| password == '') {
            $('.msg').show();
            $('.msg ').html('用户名或密码不能为空');
            setTimeout(function() {$('.msg').hide();}, 2000);
            return false;
        }
        if(code =='') {
            $('.msg').show();
            $('.msg ').html('验证码不能为空');
            setTimeout(function() {$('.msg').hide();}, 2000);
            return false;
        }

        $.ajax({
            type: "POST",
            url: 'service/login',
            dataType: 'json',
            cache: false,
            data: {username: username, password: password, code: code, auto:auto, _token: "{{csrf_token()}}"},
            success: function(data) {
                if(data == null || data.status != 0 ) {
                    codeChange()
                    $('.msg').show();
                    $('.msg ').html(data.message);
                    setTimeout(function() {$('.msg').hide();}, 2000);
                    return;
                }
                //登陆后跳转到之前的页面
                location.href='{{urldecode($http_refer)}}';
                //登陆成功
                // location.href="/home/index";
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
            }
        });

    }

</script>
</html>
