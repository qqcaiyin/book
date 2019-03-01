<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
            </div>
        </div>
    </body>
    <script>

        $(function() {

            //注册处理
            var username= $("#username"),
                mobile= $("#mobile"),
                smscode= $("#smscode"),
                password= $("#password"),
                repassword= $("#repassword"),
                agree = $("#agree");

            username.change(function() {
                checkUserName(false);
            });
            mobile.change(function() {
                checkPhone(false);
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
                var v=$.trim(username.val());
                var i= username.siblings(".Validform_checktip").children();
                if (v=='') {
                    if (issubmit) {
                        i.attr('class',"i-err").children("label").text('请输入用户名');
                    } else{
                        i.attr('class',"i-tip").children("label").text('支持中文、字母、数字、“-”“_”的组合');
                    }
                }
                else if (getStringLength(v) < 4) {
                    i.attr('class',"i-err").children("label").text('长度只能在4-20个字符之间');
                }
                else if (/^[0-9]+$/.test(v)) {
                    i.attr('class',"i-err").children("label").text('用户名不能是纯数字，请重新输入！');
                }
                else if (!/^[A-Za-z0-9_\-\u4e00-\u9fa5]+$/.test(v)) {
                    i.attr('class',"i-err").children("label").text('请使用中文、字母、数字、“-”“_”的组合');
                }
                else
                {
                    i.attr('class',"i-suc").children("label").text('');
                    isValid = true;
                }
                return isValid;
            }

            //验证手机
            function checkPhone(issubmit) {
                var isValid = false;
                var v= $.trim(mobile.val());
                var i= mobile.siblings(".Validform_checktip").children();
                if (v=='') {
                    if (issubmit) {
                        i.attr('class',"i-err").children("label").text('请输入手机号码');
                    } else{
                        i.attr('class',"").children("label").text('');
                    }
                }
                else if(!is_mobile(v))
                {
                    i.attr('class',"i-err").children("label").text('手机号码格式不正确');
                }
                else
                {
                    i.attr('class',"i-suc").children("label").text('');
                    isValid =true;
                }
                return isValid;
            }

            //验证密码
            function checkPwd(issubmit) {
                var isValid = false;
                var v=$.trim(password.val()),u=$.trim(username.val());
                var i= password.siblings(".Validform_checktip").children();
                if (v=='') {
                    if (issubmit) {
                        i.attr('class',"i-err").children("label").text('请输入密码');
                    } else{
                        i.attr('class',"i-tip").children("label").text('支持中文、字母、数字、“-”“_”的组合');
                    }
                }
                else if (getStringLength(v) < 6) {
                    i.attr('class',"i-err").children("label").text('长度只能在6-20个字符之间');
                }
                else if (v==u) {
                    i.attr('class',"i-err").children("label").text('密码与用户名相似，有被盗风险，请更换密码');
                }
                else
                {
                    if($.trim(repassword.val())!='' && v !=$.trim(repassword.val()))
                    {
                        repassword.siblings(".Validform_checktip").children().attr('class',"i-err").children("label").text('两次密码输入不一致');
                    }
                    i.attr('class',"i-suc").children("label").text('');
                    isValid = true;
                }
                return isValid;
            }

            //验证密码
            function checkRePwd(issubmit) {
                var isValid = false;
                var v=$.trim(repassword.val()),u=$.trim(password.val());
                var i= repassword.siblings(".Validform_checktip").children();
                if (v=='') {
                    if (issubmit) {
                        i.attr('class',"i-err").children("label").text('请输入密码');
                    } else{
                        i.attr('class',"").children("label").text('');
                    }
                }
                else if(v!=u)
                {
                    i.attr('class',"i-err").children("label").text('两次密码输入不一致');
                }
                else
                {
                    i.attr('class',"i-suc").children("label").text('');
                    isValid = true;
                }
                return isValid;
            }

            //协议
            function checkAgree() {
                if (agree.prop("checked")==false) {removeGoods
                    $("#agree").siblings(".Validform_checktip").children().attr('class',"i-err").children("label").text('请同意协议并勾选');
                    return false;
                }
                else
                {
                    $("#agree").siblings(".Validform_checktip").children().attr('class','').children("label").text('');
                    return true;
                }
            }

            function checkSmscode()
            {
                var v=$.trim(smscode.val());
                var i= smscode.siblings(".Validform_checktip").children();
                if (v=='') {
                    i.attr('class',"i-err").children("label").text('请填写手机验证码');
                    return false;
                }
                else
                {
                    i.attr('class','').children("label").text('');
                    return true;
                }
            }

            //用户注册
            $("#reg").click(function() {
                if (!checkUserName(true) || !checkPhone(true) || !checkSmscode() || !checkPwd(true) || !checkRePwd(true) || !checkAgree()) {
                    return;
                }
                var isOauth = $("#isOauth").length; //是否绑定第三方

                $.ajax({
                    type: "post",
                    url: "user_api.html?return_url="+(typeof(return_url) != "undefined"?return_url:""),
                    data: {
                        act:'reg',
                        username:$.trim(username.val()),
                        tel:$.trim(mobile.val()),
                        smscode: $.trim(smscode.val()),
                        password: $.trim(password.val()),
                        repassword: $.trim(repassword.val()),
                        agree: $("#agree:checked").val(),
                        isOauth: isOauth
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.err != '') {
                            msg(data.err);
                        }
                        else{
                            msg("注册成功，欢迎您的加入！");
                            setTimeout(function() {
                                window.location.href= return_url ? return_url :'/';
                            },3000);
                        }
                    },
                    error:function(data,t){
                        msg('注册失败，请您稍后再试');
                    } ,
                    complete: function(XMLHttpRequest, textStatus){}
                });
            });


            //登陆处理
            $("#loginname").change(function() {
                checkLoginname(false);
            });

            function checkLoginname(issubmit) {
                var isValid=true;
                var v = $.trim($("#loginname").val());
                var i = $("#loginname").siblings(".Validform_checktip");
                if (v=='') {
                    i.children().attr('class',"i-err").children("label").text('请填写账户名');
                    isValid = false;
                }
                else if (getStringLength(v) < 4) {
                    i.children().attr('class',"i-err").children("label").text('账户名不正确');
                    isValid = false;
                }
                else
                {
                    i.children().attr('class',"").children("label").text('');
                }

                return isValid;
            }

            function checkLoginPwd(issubmit) {
                var isValid=true;
                var v = $.trim($("#passw").val());
                var i = $("#passw").siblings(".Validform_checktip");
                if (v=='') {
                    i.children().attr('class',"i-err").children("label").text('请填写密码');
                    isValid = false;
                }
                else if (getStringLength(v) < 6) {
                    i.children().attr('class',"i-err").children("label").text('密码不正确');
                    isValid = false;
                }
                else
                {
                    i.children().attr('class',"").children("label").text('');
                }

                return isValid;
            }


            //用户登陆
            $("#login").click(function() {
                var login_name=$.trim($("#loginname").val()),
                    passw=$.trim($("#passw").val()),
                    authcode=''
                isOauth = $("#isOauth").length; //是否绑定第三方

                if (!checkLoginname(true) || !checkLoginPwd(true)) {
                    return;
                }

                if ($('.yanm-div').css("display")!='none') {
                    authcode = $.trim($("#authcode").val());
                }
                //msg(return_url);return;

                $.ajax({
                    type: "post",
                    url: "user_api.html?return_url="+(typeof(return_url) != "undefined"?return_url:""),
                    data: {
                        act: 'login',
                        username:login_name,
                        password: passw,
                        authcode:authcode,
                        autologin: $.trim($("#autologin:checked").val()),
                        isOauth: isOauth
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.err != '') {
                            msg(data.err,10000);
                            if(data.data.authcode!=undefined) {
                                $(".yanm-div").show();
                            }
                        }
                        else{
                            window.location.href= return_url ? return_url :'/';
                        }
                    },
                    error:function(data,t){
                        msg('登陆失败，请您稍后再试');
                    } ,
                    complete: function(XMLHttpRequest, textStatus){}
                });
            });

            loadLayer();
        })

        //编辑个人信息
        function edit_userinfo() {
            var	img = $.trim($("#img").val()),
                sex = $.trim($("input[name='sex']:checked").val()),
                birthday = $.trim($("#birthday").val()),
                email = $.trim($("#email").val()),
                username = $.trim($("#username").val()),
                realname = $.trim($("#realname").val());

            if (email !='' && !is_email(email)) {
                msg("邮箱格式不正确");
                return ;
            }
            if (username =='') {
                msg("请填写用户名");
                return ;
            }
            if (realname!='') {
                if (getStringLength(realname)<2) {
                    msg("真实姓名不正确");
                    return;
                }
                else if(!is_en(realname) && !is_chinese(realname)){
                    msg("真实姓名不正确");
                    return ;
                }
            }

            $.getJSON("/user.html", {act:'edit_userinfo', username:username,img:img,sex:sex,birthday:birthday,email:email,realname:realname}, function(res) {
                if(res.err && res.err != ''){
                    msg('操作失败，' + res.err);return;
                }
                if(res.url && res.url != ''){
                    window.location.href = res.url; return;
                }
                else
                {
                    msg('更新成功');
                }
            });
        }

        //绑定手机号码
        function bind_mobile(mobile, smscode) {
            if (mobile == '') {
                msg("请输入手机号码");
                return ;
            }
            else if(!is_mobile(mobile))
            {
                msg("手机号码不正确");
                return ;
            }
            if(smscode =='')
            {
                msg("请填写短信验证码");
                return ;
            }

            $.getJSON("/user.html", {act:'bind_mobile', mobile:mobile,smscode:smscode}, function(res) {
                if(res.err && res.err != '') {
                    msg('操作失败，' + res.err);return;
                }
                if(res.url && res.url != '') {
                    window.location.href = res.url; return;
                }
                else
                {
                    msg('绑定成功');
                    $("#mobile").data("old",mobile);
                    setTimeout(function(){window.location.href ="updatepwd.html";}, 1500);
                }
            });
        }

        //更改密码    f=0为用旧密码修改密码，f=1为用手机验证码修改密码，f=2为找回密码
        function updatePwd(f) {
            var f= f || 0;
            var oldpwd = $.trim($("#oldpwd").val()),
                pwd = $.trim($("#password").val()),
                repwd = $.trim($("#repassword").val()),
                smscode = '';

            if (f==0 && oldpwd =='') {
                $("#oldpwd").focus();
                msg("请输入旧密码");
                return false;
            }
            else if(f==1) {
                smscode = $("#smscode").val();
                if (smscode =='') {
                    msg("请输入手机验证码");
                    return false;
                }
            }
            if (pwd == '') {
                $("#password").focus();
                msg("请输入新密码");
                return false;
            }
            else if (getStringLength(pwd) < 6) {
                msg("新密码长度为6-20个字符");
                return false;
            }

            if (repwd == '') {
                $("#repassword").focus();
                msg("请输入确认密码");
                return false;
            }
            if (pwd != repwd) {
                msg("两次输入的密码不一致");
                return false;
            }

            $.getJSON("/user.html", {act:'updatepwd', oldpwd:oldpwd,pwd:pwd,repwd:repwd, smscode:smscode, authtype:f}, function(res) {
                if(res.err && res.err != '') {
                    msg('操作失败，' + res.err);return;
                }
                if(res.url && res.url != '') {
                    window.location.href = res.url; return;
                }
                else
                {
                    msg('修改密码成功');
                    if (f ==2) {
                        window.location.href ="findpwd.html?step=4";
                    }
                }
            });
        }

        //修改支付密码
        function editPaypwd() {
            var mobile= $.trim($("#mobile").val()),
                authcode= $.trim($("#authcode").val()),
                paypwd= $.trim($("#paypwd").val()),
                repaypwd= $.trim($("#repaypwd").val());
            if(authcode.length <4) {
                msg("请填写验证码");return;
            }
            if(paypwd=='') {
                msg("请填写支付密码");return;
            }
            if(!is_enAndnum(paypwd))
            {
                msg("支付密码请使用数字和字母，6到16个字符",4000);return;
            }
            if(repaypwd=='') {
                msg("再输入支付密码");return;
            }
            if(paypwd !== repaypwd) {
                msg("两次输入的支付密码不一致");return;
            }
            $.getJSON("/user.html", {act:'set_paypwd',mobile:mobile,authcode:authcode,paypwd:paypwd,repaypwd:repaypwd}, function(res) {
                if( (res.err && res.err != '')) {
                    msg('操作失败，' + res.err);return;
                }
                else if( (res.url && res.url != '')) {
                    msg('操作失败，您登陆超时了，请重新登陆。');
                    setTimeout("window.location.href="+res.url,3000);
                }
                else
                {
                    msg('设置成功');
                    $("#edit-paypwd,#setpaypwd").remove();
                    $("#mask").hide();
                    $("#userbalance,#userpoint").removeAttr("disabled");
                }
            });
        }

        //取消服务单
        function cancel_service(id, th) {
            if (!id) {
                msg("操作异常");return;
            }
            var t= $(th);

            $.getJSON("/user.html", {act:'cancel_service', id:id}, function(res) {
                if(res.err && res.err != '') {
                    msg('操作失败，' + res.err);return;
                }
                if(res.url && res.url != '') {
                    window.location.href = res.url; return;
                }
                else
                {
                    msg('取消成功');
                    t.parent().siblings(".status").children().html("已取消");
                    t.remove();
                }
            });
        }
    </script>
<script>

    $("#top-right").on('click','#choice>span:last-child()>span',function () {
    var that = $(this);
    if(that.is

    ("#choice>span:last-child()>span")){
    if($("#choice").children().length==3) {
    $(this).parent().remove();
    $("[name='country']").siblings().removeClass("choice-color");
    }else if($("#choice").children().length==4){
    $(this).parent().remove();
    $("[name='village']").siblings().removeClass("choice-color");
    }
    }
    });
    $("#table").on("click","[name='choice'],[name='country'],[name='village']",function () {
    $(this).siblings().removeClass("choice-color");
    $(this).addClass("choice-color");
    var a = $(this).text();
    var c = "<span class='border'>"+a+"<span>×</span></span>";
    var that = $(this);
    if(that.is

    ("[name='choice']")){
    $("[name='country']").siblings().removeClass("choice-color");
    $("[name='village']").siblings().removeClass("choice-color");
    $("#choice span:nth-child(2)").nextAll().remove();
    $("#choice span:nth-child(2)").replaceWith(c);
    }else if(that.is

    ("[name='country']")){
    if($("#choice").children().length>2){
    $("[name='village']").siblings().removeClass("choice-color");
    $("#choice span:nth-child(3)").nextAll().remove();
    $("#choice span:nth-child(3)").replaceWith(c);
    }else if($("#choice").children().length==2){
    $("#choice").append(c)
    }
    }else if(that.is

    ("[name='village']")){
    if($("#choice").children().length==4){
    $("#choice span:nth-child(4)").replaceWith(c);
    }else if($("#choice").children().length==3){
    $("#choice").append(c)
    }
    }
    });
</script>

<script>
    $(function() {
        $(".cart-tr:last-child").css("border-bottom", "none");
        $(".slide-like-pro .hd li:first-child").css("border-left", "none");
        $(".goods-title-pic:last-child").css("border-bottom", "none");
        $(".good-num:last-child").css("border-bottom", "none");
        $(".goods-price:last-child").css("border-bottom", "none");
        $(".xiaoji:last-child").css("border-bottom", "none");
        //购物数量改变时
        $("#list .result").each(function() {
            $(this).change(function() {
                var n = parseInt($(this).val());
                var p = $(this).parent();
                var chk = p.siblings(".cart-one").children("input");
                var price = p.prev().children(".g-price").html();
                p.next().children(".subtotal").html(n * price).toFixed(2);
                updateCart(p.parent().attr("id"), p.parent().data("spec"), n);
                chk.prop("checked", "checked");
                if(chk.parents(".cart-tr").hasClass("it-selected") == false) {
                    chk.parents(".cart-tr").addClass("it-selected");
                }
                sumShopping();
            });
        });

        //移除商品
        $(".removeGoods").each(function() {
            $(this).click(function() {
                var p = $(this).parent().parent();
                var ids = p.attr("id"),
                    spec = p.data("spec");
                layer.confirm('确定要删除吗', function(index) {
                    removeGoods(ids, spec);
                    top.layer.close(index);
                });
            });
        });

        //批量移除商品
        $("#removebatch").click(function() {
            var ids = '';
            var spec = '';
            $("#list input[name='chk_list']:checked").each(function() {
                ids += $(this).parent().parent().attr("id") + "@";
                spec += $(this).parent().parent().data("spec") + "@";
            });
            if(ids == '') {
                return;
            }
            ids = ids.substring(0, ids.length - 1);
            layer.confirm('确定要删除吗', function(index) {
                removeGoods(ids, spec);
                top.layer.close(index);
            });
        });

        //更新商品选择状态
        $("#list input[name='chk_list']").each(function() {
            $(this).click(function() {
                updateStatus($(this));
                setall(".btn-checkall", "#list");
            });
        });

    });

    //商品加入收藏
    $(".addfav").each(function() {
        $(this).click(function() {
            var t =$(this);
            var p = $(this).parent().parent();
            var ids = p.attr("id"),
                spec = p.data("spec");
            $.getJSON("/user.html", {
                act: 'addfav',
                gid: ids,
                spec: spec
            }, function(res) {
                if(res.err != '') {
                    msg("收藏失败，" + res.err);
                }
                else if( (res.url && res.url != '')) {
                    msg('操作失败，请先登陆。');
                    setTimeout("window.location.href="+res.url, 3000);
                }
                else {
                    msg("收藏成功");
                    t.replaceWith('<span style="color: #999;">已收藏</span>')
                }
            });
        });
    });

    //取消收藏
    function delFav(gid, spec,th) {
        var t =$(th);
        $.getJSON("/user.html", {
            act: 'del_fav',
            gid: gid,
            spec: spec
        }, function(res) {
            if(res.err != '') {
                msg("取消失败，" + res.err);
            }
            else if( (res.url && res.url != '')) {
                msg('操作失败，请先登陆。');
                setTimeout("window.location.href="+res.url, 3000);
            }
            else {
                msg("取消成功");
                t.parents("li").eq(0).remove();
            }
        });
    };

    //去结算
    function gotoOrder() {
        var total=$.trim($("#selectnum").html());
        if (total=='' || parseInt(total)==0) {
            msg("请选择要结算的商品");
            return;
        }
        window.location.href = '/order.html';
    };

    //更新购物车商品状态
    function updateStatus(t) {
        var p = t.parents(".cart-tr");
        var gid = p.attr("id"),
            spec = p.data("spec"),
            status = t.prop("checked") ? 1 : 0;
        var data = {
            act: 'set_cart_status',
            gid: gid,
            spec: spec,
            status: status
        }
        $.getJSON("/cart.html", data, function(res) {
            if(res.err && res.err != '') {
                msg('操作失败，' + res.err);
            }
        });
        if(status == 1) {
            p.addClass("it-selected");
        } else {
            p.removeClass("it-selected");
        }
        sumShopping();
    }

    //更新购物车
    function updateCart(gid, spec, total) {
        var data = {
            act: 'addtocart',
            gid: gid,
            spec: spec,
            total: total
        };
        $.getJSON("/cart.html", data, function(res) {
            if(res.err && res.err != '') {
                msg('操作失败，' + res.err);
            } else {
                $(".cartinfo").html($.cookie("cnum"));
            }
        });
    }

    //保存收货地址
    function saveconsignee() {
        var id = $.trim($("#id").val()),
            name = $.trim($("#sh-name").val()),
            mobile = $.trim($("#sh-phone").val()),
            tel = $.trim($("#sh-tel").val()),
            district = $.trim($("#district").val()),
            address = $.trim($("#sh-address").val()),
            isdefault = $("#isdefault").is(":checked")? 1:0;

        if (name=='') {
            msg("请填写收货人");
            return;
        }
        else
        {
            var errorFlag = false;
            if(!is_consignee(name)){
                errorFlag = true;
            }else if(name.search(/·{2,}/) > -1){
                errorFlag = true;
            }
            if(errorFlag){
                msg("收件人姓名仅支持中文或英语");
                return;
            }
        }
        if (mobile=='') {
            msg("请填写手机号码");
            return;
        }
        else if (!is_mobile(mobile)) {
            msg("手机号码格式不正确");
            return;
        }
        if (tel!='' && !is_tel(tel)) {
            msg("固定电话格式不正确");
            return;
        }
        if (district=='' || district.length < 3) {
            msg("请选择所在地区");
            return;
        }
        if (address =='') {
            msg("请填写详细地址");
            return;
        }
        var data={
            act:"edit_consignee",
            id:id,
            name:name,
            mobile:mobile,
            tel:tel,
            district:district,
            address:address,
            isdefault:isdefault
        }
        $("#saveconsignee").attr("disabled", "disabled");
        $.getJSON("/order.html", data, function(res) {
            $("#saveconsignee").removeAttr("disabled");
            if(res.err && res.err != '') {
                msg('操作失败，' + res.err);return;
            }
            else if( (res.url && res.url != '')) {
                msg('操作失败，您还未登陆');
                //setTimeout("window.location.href='"+res.url+"'",3000);
            }
            else
            {
                msg("保存成功");
                $("#mask,.edit-address").hide();
                address = $("#store-selector .text>div").html()+address;
                if (isdefault==1) {
                    $("li.other-add").find(".moblie").siblings("span").html('');
                }
                if (id=='' || id=='0') {
                    id = res.res;
                    $(".sh-address ul li.other-add").removeClass("default-add");
                    var html= '<li class="other-add default-add" id="'+ id+'" data-cityid="'+curArea.curCityId+'">';
                    html += '<div class="add-box"><span class="remove vivi-blue" onclick="removeAddr('+id+');">X</span>';
                    html += '<div class="name-add"><span class="name">'+name+'</span><span class="add-rside"></span></div>';
                    html += '<div class="elli add-detail"><p title="'+address+'">'+address+'</p></div>';
                    html += '<div><span class="moblie">'+mobile+'</span><span style="margin-left: 30px;">'+(isdefault==1?'默认地址':'')+'</span>';
                    html += '<a href="javascript:void(0);" onclick="editAddr('+id +');" class="chang-default change vivi-blue">修改</a></div></div><i class="icon-check"></i></li>';
                    $(".sh-address .add-add").before(html);
                } else{
                    $("#"+id).data("cityid", curArea.curCityId).find(".name").html(name);
                    $("#"+id).find(".moblie").html(mobile);
                    if (isdefault==1) {
                        $("#"+id).find(".moblie").siblings("span").html('默认地址');
                    }

                    $("#"+id).find(".add-detail").children().attr("title", address).html(address);
                }
            }
        });

    }

    //关闭窗口
    $("i.close-modbox").click(function(){
        $("#mask,.modbox").hide();
    });
    //新增地址saveconsignee
    function addAddr(){
        $("#mask").show();$(".edit-address").slideDown(200);

        $("#id").val('');
        $("#sh-name").val('');
        $("#sh-phone").val($("#user_mobile").val());
        $("#sh-tel").val('');
        $("#district").val('');
        $("#sh-address").val('');
        $("#isdefault").removeAttr("checked");
        location_init();
    };

    //编辑地址
    function editAddr(id){
        if (id ==undefined || id==0) {
            return;
        }
        $("#mask").show();$(".edit-address").slideDown(200);
        $("#saveconsignee").attr("disabled", "disabled");

        $.getJSON("/order.html", {id:id,act:'get_consignee'}, function(res) {
            if( (res.err && res.err != '') || res.data.length==0) {
                msg('加载地址失败，' + res.err);return;
            }
            else if( (res.url && res.url != '')) {
                msg('操作失败，您还未登陆');
                setTimeout("window.location.href="+res.url,3000);
            }
            else
            {
                $("#id").val(id);
                $("#sh-name").val(res.data[0].name);
                $("#sh-phone").val(res.data[0].mobile);
                $("#sh-tel").val(res.data[0].tel);
                $("#district").val(res.data[0].name);
                $("#sh-address").val(res.data[0].address);
                $("#isdefault").attr("checked",res.data[0].is_default==1);
                curArea.curProvinceId = res.data[0].province;
                curArea.curCityId = res.data[0].city;
                curArea.curAreaId = res.data[0].area;
                curArea.curTownId= res.data[0].town;
                page_load=true, edit_init=true;
                chooseProvince(curArea.curProvinceId);
            }
            $("#saveconsignee").removeAttr("disabled");
        });
    };

    //删除地址
    function removeAddr(id) {
        layer.confirm('确定要删除吗', function(index) {
            var d= $("li.default-add");
            $.getJSON("/order.html", {id:id,act:'del_consignee'}, function(res) {
                if( (res.err && res.err != '')) {
                    msg('操作失败，' + res.err);return;
                }
                else if( (res.url && res.url != '')) {
                    msg('操作失败，您登陆超时了，请重新登陆。');
                    setTimeout("window.location.href="+res.url,3000);
                }
                else
                {
                    msg('删除成功');
                    $("#"+id).remove();
                }
                d.addClass("default-add");
                $("#saveconsignee").removeAttr("disabled");
            });
            top.layer.close(index);
        });
    }
    //选择地址
    $(".sh-address ul li.other-add").each(function() {
        $(this).click(function() {
            $(this).addClass("default-add").siblings().removeClass("default-add");
        });
    });

    var goods_amount = 101.15;
    var mostpoint = 50; //最多不超过每笔订单结算金额
    var pointpay = 100; //每pointpay个积分可抵1元
    var is_invoice=1;
    var is_paypwd=false;
    $(function(){
        loadLayer();
        $(".ul-pro-box li").each(function(){
            if($(this).index()%3==2){
                $(this).css("margin-right","0");
            }
        });
        $(".slide-like-pro").slide({});

        setTimeout(function() {
            get_coupon_list();
        }, 100);
    });

    $("#loginmobile").change(function() {
        var mobile  = $.trim($(this).val());
        if (is_mobile(mobile) == false) {
            msg("请输入正确手机号码")
            return;
        }
        check_mobile(mobile, callback_check_mobile);
    });

    function callback_check_mobile(res) {
        if ($.trim($("#btnSendCode").data("act")) =='user_bind') {
            return false;
        }
        if(res.err && res.err !='')//已注册
        {
            $("#btnSendCode").data("act", 'login');
        }
        else
        {
            $("#btnSendCode").data("act", 'reg');
        }
    }

    $("#btnlogin").click(function() {
        var mobile = $.trim($("#loginmobile").val()), smscode = $.trim($("#smscode").val()),
            act = $.trim($("#btnSendCode").data("act"));

        $.post("user_api.html",
            {   act: act,
                authtype:1,//短信验证
                username: (act=='reg' ? '' : mobile),
                tel: mobile,
                smscode: smscode,
                password: '',
                repassword: '',
                agree: 1,
                isOauth: 0,
                authcode: '',
                autologin:1
            },
            function(data) {
                if (data.err != '') {
                    msg(data.err);
                }
                else{
                    msg("登陆成功");
                    setTimeout(function() {
                        window.location.reload();
                    },1500)
                }
            },"json");

    });

    //发送验证码
    $("#btnSendCode").click(function() {
        var act= $.trim($(this).data("act"))
        sendSms($(this)[0], 'sms_'+ (act=="user_bind" ?'login':act));
    })

    $("#is_invoice a").click(function() {
        if ($(this).attr("id") == "1") {
            $("#invoiceinfo").slideDown(200);
        }
        else
        {
            $("#invoiceinfo").slideUp(100);
        }
    });

    //优惠券
    $(".h3dy .yhdyong").click(function() {
        $(this).find("i.icon-arrow").toggleClass("icon-down");
        $(".youhui-box").slideToggle(500);
    });
    $(".useful li").each(function() {
        $(this).click(function() {
            $(this).toggleClass("checked").siblings().removeClass("checked");
            inputdis();
        });
    });

    //输入余额、积分
    $("#balance, #point").blur(function() {
///inputdis();
//calcTotal();
    });

    //选中使用余额
    $("#userbalance").click(function () {
        inputdis();
        calcTotal();
        $("#balance").css("display", $(this).is(":checked")?"inline-block":"none") ;
    });

    //选中使用积分
    $("#userpoint").click(function () {
        inputdis();
        calcTotal();
        $("#point").css("display", $(this).is(":checked")?"inline-block":"none") ;
    });

    //结算
    $(".btn-jiesuan").click(function() {
        if($("#btnSendCode").length>0 && $.trim($("#btnSendCode").data("act")) =='user_bind')
        {
            $("#loginmobile").focus();
            msg("请先绑定手机号码");return;
        }
        if ($(".other-add").length==0) {
            msg("请先填写您的收货人信息");return;
        }
        if ($(".default-add").length==0) {
            msg("请选择您的收货地址");return;
        }
        if ($("#payAmount").html() !=0 && $("#paylist li a.selected").length==0) {
            msg("请选择支付方式");return;
        }
        if ($("#expresslist li a.selected").length==0) {
            msg("请选择配送方式");return;
        }

        if (is_paypwd && $.trim($("#cbkpaypwd").val()) == '') {
            msg("请填写支付密码");return;
        }
//发票信息
        var invoice_title ='', invoice_con ='';
        if ($("#is_invoice a.selected").attr("id") ==1) { //开启发票功能
            var sl_title = $("#invoice_tite_list a.selected");
            invoice_title = sl_title.attr("id") ==1 ? sl_title.html() : $.trim(sl_title.children().val());
            invoice_con = $("#invoice_con a.selected").attr("id");
            if (invoice_title=='') {
                msg("请填写发票抬头");return;
            }
            if (invoice_con =='') {
                msg("请填写发票内容");return;
            }
        }

        var data ={
            act : 'add_order',
            cneeid: $(".default-add").attr("id"),
            balance:$("#userbalance").is(":checked")? $.trim($("#balance").val()) :0 ,
            point : $("#userpoint").is(":checked")? $.trim($("#point").val()) :0 ,
            pay : $("#paylist li a.selected").attr("id"),
            exp_id : $("#expresslist li a.selected").attr("id"),
            paypwd : is_paypwd ? $.trim($("#cbkpaypwd").val()) : '',
            invoice_title: invoice_title,
            invoice_con : invoice_con,
            user_remark : $("#leavemess").val(),
            coupon_ids:getCouponIDs()//会员优惠券
        };

        $(this).attr("disabled", "disabled");
        $.getJSON("order.html", data, function(res) {
            if( (res.err && res.err != '')) {
                msg('操作失败，' + res.err);return;
            }
            if( (res.url && res.url != '')) {
                window.location.href = res.url;
            }

            $(this).removeAttr("disabled");
        });
    });

    //显示支付密码框
    function inputdis() {
        if( $("#userbalance").is(":checked") || $("#userpoint").is(":checked") || $(".useful li").hasClass("checked")) {
            $(".result-box .lside .save-passw").show();
            is_paypwd= true;
        } else {
            $(".result-box .lside .save-passw").hide();
            is_paypwd=false;
        }
    }

    var is_count=1,//各状态数量
        page = 1; //当前页码
    //加载优惠券
    function get_coupon_list() {
        var ids_arr = Array();
        $(".goodinfor").each(function() {
            ids_arr.push($(this).attr('id'));
        })
        var goods_ids = ids_arr.toString();

        $.getJSON("myquan.html", {act: "get_coupon", page:page,num:100, goods_ids:goods_ids, is_count:is_count,type:0,is_available:1}, function(res) {
            var html ='';
            if(res.err) {
                msg("加载优惠券失败，".res.err);return;
            }
            var n =0;
            $.each(res.data, function(k, v) {
                n++;
                html +='<div class="cp-it '+(n%5 ==0 ? 'last' :'')+(v.is_selected==1 ? ' selected' :'')+(v.is_vaild==0 ? ' disabled' :'')+ '" id="'+v.id+'" data-cid="'+v.cid+'" data-amount="'+v.amount+'"><div class="hd">';
                html +='<span class="amount">￥<b>'+v.amount+'</b></span>';
                html +='<span class="amount_reached">满 '+v.amount_reached+'元 可用</span>';
                html +='<span class="date">'+v.date_start+'-'+v.date_end+'</span></div>';
                html +='<div class="bt"><div class="option">';
                html +='<span><label>限品类</label>：<b class="tit" title="'+v.name+'">'+v.name+'</b></span>';
                html +='<span><label>限平台</label>：'+v.client_name+'</span>';
                html +='<span><label>限等级</label>：'+v.grade_name+'<i class="tip-down"></i></span>';
                html +='<span><label>券编号</label>：'+v.code+'</span></div></div><i class="icon-check-zf"></i></div>';
            });

            if(is_count ==1)
            {
                is_count=0;
                $("#couponnum").html(res.count[0]);
            }
            if (res.data.length==0) {
                return;
            }

            $(".couponlist").append(html);
            calcTotal();
            sumSelected();
            page++;
        });
    }

    //选择优惠券
    $(".couponlist").each(function() {
        $(this).on("click",".cp-it",function() {
            var t =$(this);
            if(t.hasClass("disabled")) {
                return;
            }

            var cid = t.data("cid");
            if(t.hasClass("selected"))
            {
                t.removeClass("selected");
            }
            else
            {
                var ids = getSelectedCoupon(); //已选
                if(ids !='' && t.hasClass("selected") ==false) {
                    $.getJSON("myquan.html", {act: "select_coupon", id: cid, ids: ids}, function(res) {
                        var html ='';
                        if(res.err) {
                            msg("选择优惠券失败，".res.err);return;
                        }
                        if(res.data && res.data.length > 0) {
                            $.each(res.data, function(k, v) {
                                var coupon = $(".couponlist>.selected[data-cid='"+v+"']");
                                $(".couponlist>.selected[data-cid='"+v+"']").each(function() {
                                    if($(this).attr("id") != t.attr("id")) {
                                        $(this).removeClass("selected");
                                    }
                                })
                            });
                        }
                        sumSelected();
                        calcTotal();
                    });
                }

                t.addClass("selected");
            }

            sumSelected();
            calcTotal();
        });
    });

    function sumSelected(num) {
        num = num || $(".couponlist>.selected").length;
        $("#couponselected").html("已选<b class='orange-bold'> "+ num + "</b> 张").css("display", (num == 0 ? "none" :"inline-block") );
    }

    //获取优惠券id
    function getSelectedCoupon(){
        var ids = '';
        $(".couponlist>.selected").each(function() {
            ids += $(this).data("cid") + ",";
        });
        if (ids !='') {
            ids = ids.substr(0, ids.length - 1);
        }
        return ids;
    }

    //获取会员优惠券id
    function getCouponIDs(){
        var ids = '';
        $(".couponlist>.selected").each(function() {
            ids += $(this).attr("id") + ",";
        });
        if (ids !='') {
            ids = ids.substr(0, ids.length - 1);
        }
        return ids;
    }

    //支付密码
    $("#setpaypwd a").click(function() {
        $("#mask").show(); $("#edit-paypwd").slideDown(200);
    });

    //计算订单金额   使用顺序  优惠券>积分>余额
    function calcTotal() {
        var sum =0;
        var expfee = parseFloat($("#expfee").html());
        var payAmount = goods_amount + expfee; //应付金额
        var point_use = 0;//使用积分
        var point = parseFloat($("#point").siblings().children("b").html()); //现有积分
        var balance_use = 0;//使用余额
        var balance = parseFloat($("#balance").siblings().children("b").html()); //现有余额
        var point_amount = 0,balance_amount =0,coupon_amount = 0; //抵用的金额

        //优惠券
        coupon_amount = getCouponAmount();
        payAmount = payAmount - coupon_amount;

        //积分
        if($("#userpoint").is(":checked")) {
            var point_amount = parseInt(payAmount * mostpoint * 0.01),
                point_use = point_amount * pointpay;
            if(point_use > point) //小于现有积分
            {
                point_use = point - point % pointpay; //使用积分
                point_amount = point_use/pointpay;
            }
            point_amount = point_amount.toFixed(2);
            payAmount = payAmount - point_amount;
            $("#point").val(point_use);
        }
        else
        {
            $("#point").val('');
        }

        //余额
        if($("#userbalance").is(":checked") && payAmount>0) {
            balance_use = payAmount > balance ? balance : payAmount;//使用余额
            payAmount = payAmount - balance_use;
            $("#balance").val(balance_use);
        }
        else
        {
            $("#balance").val('');
        }

        //显示使用的情况
        //优惠券
        if (coupon_amount >0) {
            if ($("#coupon-offset").length==0) {
                $(".calu-box").append('<p class="slivergrey"><span>优惠券抵用：</span><span class="txtmoney">￥<b id="coupon-offset">-'+ coupon_amount+'</b></span></p>');
            }
            else
            {
                $("#coupon-offset").html("-"+coupon_amount);
            }
        }
        else
        {
            $("#coupon-offset").parents(".slivergrey").remove();
        }


        if ($("#userpoint").is(":checked")) {
            if ($("#point-offset").length==0) {
                $(".calu-box").append('<p class="slivergrey"><span>积分抵用：</span><span class="txtmoney">￥<b id="point-offset">-'+point_amount +'</b></span></p>');
            } else{
                $("#point-offset").html("-"+point_amount);
            }
        }
        else{
            $("#point-offset").parents(".slivergrey").remove();
        }
        if ($("#userbalance").is(":checked")) {
            if ($("#balance-offset").length==0) {
                $(".calu-box").append('<p class="slivergrey"><span>余额抵用：</span><span class="txtmoney">￥<b id="balance-offset">-'+ balance_use+'</b></span></p>');
            } else{
                $("#balance-offset").html("-"+balance_use);
            }
        }
        else{
            $("#balance-offset").parents(".slivergrey").remove();
        }

        $(".txtmoney b").each(function() {
            sum+= parseFloat($.trim($(this).html()));
        });
        $("#payAmount").html(sum);
        if (sum == 0)
        {
            $("#paylist").parent().hide(200);
        }
        else
        {
            $("#paylist").parent().slideDown(200);
        }
    }

    //获得优惠券金额
    function getCouponAmount() {
        var coupon_amount = 0;
        if($("#couponlist").length>0)
        {
            $("#couponlist>.selected").each(function() {
                coupon_amount += parseInt($.trim($(this).data("amount")));
            });
        }
        return coupon_amount;
    }

    $(".zhifu-box ul.zfb li").each(function() {
        $(this).click(function() {
            $(this).find("a").addClass("selected").end().siblings().find("a").removeClass("selected");
            $(this).children("i.icon-check-zf").css("display", "block").end().siblings().children("i").css("display", "none");
        });
    });

    //获取运费
    $("#expresslist li a").click(function() {
        $.getJSON("/order.html", {act:'get_expfee',id:$(this).attr("id"), cityid: $(".sh-address .default-add").data("cityid") }, function(res) {
            if(res.err && res.err != '') {
                msg('操作失败，' + res.err);return;
            }
            else
            {
                $("#expfee").html(res.res);
                calcTotal();
            }
        });
    });








</script>
<script>

    $(function(){
        $(".menu-mainnav li").each(function(){
            $(this).mouseover(function(){
                $(".menu-subnav .navsonbox").eq($(this).index()).addClass("on").fadeIn().siblings().removeClass("on").fadeOut();
            });
        });
        $(".menu-subnav").mouseleave(function(){
            $(".menu-subnav .navsonbox").hide();
        })
    });
    //将时间减去1秒，计算天、时、分、秒
    function SetRemainTime(n) {
        //n = n || '';
        var SysSecond = parseInt($("#time"+n).data("time"));
        if (SysSecond > 0) {
            SysSecond = SysSecond - 1;
            var second = Math.floor(SysSecond % 60);           // 计算秒
            var minute = Math.floor((SysSecond / 60) % 60);    //计算分
            var hour = Math.floor((SysSecond / 3600) % 24);    // 计算时
            var day=Math.floor((SysSecond / 86400));      //计算天
            $("#v_hour"+n).html( hour);
            $("#v_minute"+n).html( minute);
            $("#v_second"+n).html( second);
            $("#v_day"+n).html(day)
            $("#time"+n).data("time", SysSecond);
        } else {//剩余时间小于或等于0的时候，就停止间隔函数
            /* window.clearInterval(InterValObj+n);  */
            //这里可以添加倒计时时间为0后需要执行的事件
        }
    }
    //fenge

    var domain = '//' + window.location.host; //默认域名
    //从url中获取参数
    function getParam(paramName) {
        var p = "";
        if(this.location.search.indexOf("?") == 0 && this.location.search.indexOf("=") > 1) {
            var arr = decodeURIComponent(this.location.search).substring(1, this.location.search.length).split("&");
            $.each(arr, function(k, v) {
                if(v.indexOf("=") > 0 && v.split("=")[0].toLowerCase() == paramName.toLowerCase()) {
                    p = v.split("=")[1];
                    return false;
                }
            });
        }
        return p;
    }

    $(function() {
        var ishover = false;
        $(".all-part-nav").hover(function() {
            $(".ny-menu-box").show();
            $(".menu-box").css({
                "width": "100%",
                "display": "block"
            });
            $(".navbar-hover").show();
        }, function(e) {
            setTimeout(function() {
                if(ishover==false){
                    $(".ny-menu-box").trigger("mouseleave");
                }
            }, 0);
        });
        $(".ny-menu-box").mouseover(function() {
            ishover = true;
        }).mouseleave(function() {
            $(this).hide();
            ishover = false;
        });
        $('.totop').click(function() {
            $('html,body').animate({
                scrollTop: '0px'
            }, 300);
        });
        $(".nav-pic-menu li:first-child").css("border-top", "none");
        $(".nav-pic-menu li:last-child").css("border-bottom", "none");
        $(".nav-pic-menu li").each(function() {
            $(this).mouseover(function() {
                $(this).prev().css("border-bottom-color", "#fff");
                $(this).next().css("border-top-color", "#fff");
                $(this).css("border-color", "#fff");
                $(".navbar-hover").show();
            });
            $(this).mouseleave(function() {
                $(this).prev().css("border-bottom-color", "#fff");
                $(this).next().css("border-top-color", "#fff");
                $(this).css("border-color", "#fff");
                $(".navbar-hover").hide();
            });
        });
        $(".nav-pic-menu li").each(function() {
            $(this).mouseover(function() {
                $(".menu-box").css("width", "100%");
            });
            $(this).mouseleave(function() {
                $(".menu-box").css("width", "250px");
            })
        });

        $(".select-mod a").each(function() {
            $(this).click(function() {
                $(this).addClass("selected").siblings().removeClass("selected");
                if ($(this).parents("#ym-item").length>0) {
                    var spec ='';
                    $("#goods-spec .it .selected").each(function() {
                        spec += $(this).attr("id")+ ',';
                    });
                    if (spec !='') {
                        spec = spec.substr(0, spec.length - 1);
                    }
                    $.getJSON("/item.html",{act:'get_specinfo', id:goods_id, spec:spec}, function(res) {
                        $("#ym-price").html(res.data.price);
                        $("#goods_num").data("max",res.data.number);
                        if ($("#user_discount").val() !='') {
                            $("#ym-userprice").html((res.data.goods_price * $("#user_discount").val()).toFixed(2));
                        }

                    });
                }
                else{
                    $("#ym-price").html(price);
                }
            });
        });
    });

    function onlyNum(t) {
        t.value = t.value.replace(/[^\d]/g, '');//  /[^\d\.]/g
    }

    //金额
    function onlyAmount(th){
        var a = [
            ['^0(\\d+)$', '$1'], //禁止录入整数部分两位以上，但首位为0
            ['[^\\d\\.]+$', ''], //禁止录入任何非数字和点
            ['\\.(\\d?)\\.+', '.$1'], //禁止录入两个以上的点
            ['^(\\d+\\.\\d{2}).+', '$1'] //禁止录入小数点后两位以上
        ];
        for(i=0; i<a.length; i++){
            var reg = new RegExp(a[i][0]);
            th.value = th.value.replace(reg, a[i][1]);
        }
    }

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
        return /^(13|14|15|16|17|18|19)[0-9]{9}$/.test(v);
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

    //字符串长度
    function getStringLength(str) {
        if(!str) {
            return;
        }
        var bytesCount = 0;
        for(var i = 0; i < str.length; i++) {
            var c = str.charAt(i);
            if(/^[\u0000-\u00ff]$/.test(c)) {
                bytesCount += 1;
            } else {
                bytesCount += 2;
            }
        }
        return bytesCount;
    }

    function words_deal(th) {
        var t = $(th);
        var curLength = t.val().length;
        if(curLength > 200) {
            t.val(t.val().substr(0, 200));
        } else {
            t.parent().siblings().find("em").text(200 - t.val().length);
        }
    }
    //全选
    function checkall(t, list) {
        var checked = $(t).prop("checked");
        $(".btn-checkall").prop("checked", checked);
        $(list).find("input[type='checkbox']").each(function() {
            $(this).prop("checked", checked);
            updateStatus($(this));
        });
    }

    function setall(t, list) {
        if($(list).find("input[type='checkbox']:checked").length == $(list).children().length) {
            $(t).prop("checked", "checked");
        } else {
            $(t).prop("checked", "");
        }
    }



    //添加多个商品到购物车   多个商品Id和规格分别用-分隔, 如    1-2-3   白色-64g
    function addcartMult(gid, direct, num, spec)
    {
    if (gid ==undefined || gid=='') {
    msg("商品编号不能为空");
    }
    var gids = gid.split("-"), specs=spec.split("-");
    if (gids.length==0) {
    return;
    }
    for (var i = 0; i < gids.length; i++) {
    if ($.trim(gids[i])!='') {
    addCart($.trim(gids[i]), 0, num, specs[i]);
    }
    }
    if(direct && direct ==1) {
    window.location.href = '/cart.html?directbuy=1';
    }
    }

    //添加到购物车
    function addCart(gid, direct, num, spec) {
    num = num || $("#goods_num").val();
    var spec = spec==undefined ? '' : spec;
    if (spec==0) {
    var err ='';
    spec='';
    $("#goods-spec .it").each(function() {
    if ($(this).find(".selected").length==0) {
    err += "请选择 " + $(this).children(".spec-name").html()+"<br>";
    }
    else{
    spec +=$(this).find(".selected").attr("id")+',';
    }
    });
    if (err !='') {
    msg(err);
    return;
    }
    if (spec!='') {
    spec =spec.substr(0, spec.length-1);
    }
    }
    var data = {
    act: 'addtocart',
    gid: gid,
    spec: spec,
    type: 1,
    num: num,
    direct:direct
    };

    $.getJSON("/cart.html", data, function(res) {
    if(res && res.url) {
    window.location.href = res.url;
    return;
    }
    if(res.err && res.err != '') {
    msg('加入购物车失败，' + res.err);
    } else {
    $(".cartinfo").html(res.res);
    msg('已加入购物车');
    if(direct && direct ==1) {
    window.location.href = '/order.html?directbuy=1';
    }
    }
    });
    }

    function removeGoods(ids, spec) {
    $.getJSON("/cart.html", {
    act: 'remove_goods',
    gid: ids,
    spec: spec
    }, function(res) {
    if(res.err != '') {
    msg("删除失败，" + res.err);
    } else {
    msg("删除成功");
    $(".cartinfo").html(res.res);
    var list = ids.split("@");
    $.each(list, function(k, v) {
    $("#" + v).remove();
    });

    sumShopping();
    }
    });
    }

    //更新已选数目
    function sumShopping() {
    var n = 0,p = 0;
    if ($("#list input[name='chk_list']").length>0) {
    $("#list input[name='chk_list']:checked").each(function() {
    n += parseFloat($(this).parent().siblings(".btn-add-reduce").children(".result").val());
    p += parseFloat($(this).parent().siblings(".cart-five").children(".subtotal").html())
    });
    }
    else{
    $("#cart-list li").each(function() {
    n += parseInt($(this).find("span.mincart-num").html());
    p += parseFloat($(this).find("span.mincart-price").html()) * parseInt($(this).find("span.mincart-num").html());
    });
    }

    $("#selectnum").html(n);
    $("#total").html(p.toFixed(2));
    $("#cart-total").html(p.toFixed(2));
    }

    //计算=数量
    function computeNum(obj, isPlus) {
    var txtNum = (isPlus == "" ? obj : obj.siblings(".result"));
    var max = txtNum.data("max");
    var n = parseInt($.trim(txtNum.val()));
    n = isNaN(n) ? 1:n;
    max = max || 9999;
    if(isPlus != undefined && isPlus == "add" && n <= max) {
    n++;
    } else if(isPlus != undefined && isPlus == "reduce" && n > 1) {
    n--;
    }
    if(n > max) {
    n = max;
    msg(txtNum.data("msg")? txtNum.data("msg"):"抱歉，库存只有" + n + "件");
    }
    if(n < 1) {
    n = 1;
    }
    txtNum.val(n);
    }

    $(function() {
    //购买数量
    $(".add").click(function() {
    computeNum($(this), "add");
    $(this).siblings(".result").trigger("change");
    });
    $(".reduce").click(function() {
    computeNum($(this), "reduce");
    $(this).siblings(".result").trigger("change");
    });
    $(".result").keyup(function() {
    computeNum($(this), "");
    });

    $(".elli").each(function(i) {
    var divH = $(this).height();
    var $p = $("p", $(this)).eq(0);
    while($p.outerHeight() > divH) {
    $p.text($p.text().replace(/(\s)*([a-zA-Z0-9]+|\W)(\.\.\.)?$/, "..."));
    };
    });

    //价格
    $("#btnprice").click(function() {
    var m = $.trim($("#price-min").val()),
    l = $.trim($("#price-max").val());
    m = m == '' ? 0 : parseInt(m);
    l = l == '' ? 0 : parseInt(l);
    if(m == 0 && l == 0) {
    return;
    }
    var href = window.location.href;
    var newurl = '';
    if(href.indexOf("pr=") == -1) {
    newurl = href + (href.indexOf("?") == -1 ? "?" : "&") + "pr=" + m + "-" + l
    } else {
    var slist = window.location.search.substring(1,window.location.search.length-1);
    var list = slist.split('&');
    newurl = window.location.pathname + "?";
    $.each(list, function(k, v) {
    if(v.indexOf("pr=") == 0) {
    newurl += "pr=" + m + "-" + l + "&";
    } else {
    newurl += list[k] + "&";
    }
    });
    }

    window.location.href = newurl;
    });

    //购物车
    $(".web-title-container .cartbox").mouseover(function() {
    show_cartinfo($(this));
    });

    $(".cart-slidedown").mouseover(function(e) {
    e.stopPropagation();
    });

    var carthtml= $(".cart-slidedownbox ul").html();
    $(".cart-slidedownbox ul").html("");

    function show_cartinfo(t) {
    $.getJSON("/cart.html", {act: 'get_cart'}, function(res) {
    if(res.err && res.err != '') {

    } else {
    $(".cartinfo").html(res.data.num);
    $("#cart-total").html(res.data.amount);
    var $html='';
    if (res.data !=false) {
    $.each(res.data.goods, function(k, v) {
    $html += carthtml;
    $html = $html.replace(/\[goods_id\]/g, v.goods_id).replace(/\[spec_name\]/g, v.spec_name).replace(/\[url\]/g, v.url).replace(/\[name\]/g, v.name).replace(/\[thumb\]/g, v.thumb).replace(/\[price\]/g, v.price).replace(/\[num\]/g, v.num);
    });
    }

    $(".cart-slidedownbox ul").html($html);
    $(".slidecart-js").attr("href", res.data.num >0 ?"/cart.html":"javascript:void(0);")

    //移除商品
    $(".delgoods").each(function() {
    $(this).click(function() {
    var p = $(this).parents("li");
    var ids = p.attr("id"),spec = p.data("spec");
    removeGoods(ids, spec);
    });
    });

    }
    });
    }

    });

    $(".btn-search").click(function() {
    if ($.trim($("#word").val()) =='') {
    return false;
    }
    });

    //取消订单
    function order_cancel(oid) {
    top.layer.confirm('确定要取消该订单吗？', function(index) {
    $.getJSON("./order.html", {
    act: 'order_cancel',
    oid: oid
    }, function(res) {
    if (res.err && res.err != '') {
    msg('取消失败，' + res.err);
    return;
    }
    if (res.url && res.url != '') {
    window.location.href = res.url;
    return;
    } else {
    msg('取消成功');
    setTimeout(function() {
    window.location.reload();
    }, 1500);
    }
    });
    top.layer.close(index);
    });
    }

    //确认收货
    function confirm_receiving(oid) {
    if (!oid) {
    return;
    }
    layer.confirm('请确认是否已收到货？', function(index) {
    $.getJSON("/order.html", {act:'confirm_receiving', oid:oid}, function(res) {
    if(res.err && res.err != '') {
    msg('操作失败，' + res.err);return;
    }
    if(res.url && res.url != '') {
    window.location.href = res.url; return;
    }
    else
    {
    msg('您已确认收货');
    setTimeout(function() {
    window.location.reload();
    },2000);
    }
    });
    top.layer.close(index);
    });
    }

    //验证码倒数
    function countDown(el,wait){
    var util = {
    wait: wait || 60,
    hsTime: function(that) {
    var _this = this;
    if (_this.wait == 0) {
    $(el).removeAttr("disabled").val('获取验证码');
    _this.wait = 60;
    } else {
    $(that).attr("disabled", true).val( _this.wait + '秒后重发');
    _this.wait--;
    setTimeout(function () {
    _this.hsTime(that);
    }, 1000)
    }
    }
    }
    util.hsTime(el);
    $(el).click(function(){
    util.hsTime(el);
    });
    }

    //发送验证码统一函数
    function sendSms(t, act, mobile) {
    if (typeof(mobile)=="undefined") {
    var t = $(t);
    if(t.data("mobileid") != "undefined")
    {
    var	ipt_mobile = $("#"+t.data("mobileid"));
    }
    else
    {
    var ipt_mobile= t.siblings("#mobile");
    }
    var mobile = $.trim(ipt_mobile.val());
    }

    var err = '';
    if (mobile == '') {
    err = "请输入手机号码";
    } else if (!is_mobile(mobile)) {
    err ="手机号码不正确";
    }

    if (err != '') {
    msg(err);
    if(ipt_mobile) {
    ipt_mobile.focus();
    }
    }

    $.getJSON("user_api.html", {
    act: act,
    mobile: mobile
    },
    function(res) {
    if (res.err && res.err != '') {
    msg("发送失败，" + res.err, 4000);
    return;
    } else {
    msg("验证码已发送，10分钟内有效");
    return;
    }
    });
    };

    //获取cookies函数   name:cookie名字

    function getCookie(name){
    var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
    if(arr != null){
    return unescape(arr[2]);
    }else{
    return null;
    }
    }

    //检测手机是否存在
    function check_mobile(mobile, callback) {
    $.getJSON("user_api.html", {act:'check_mobile',mobile:mobile}, function(res){
    if (typeof callback === "function"){
    callback(res);
    };
    });
    }

    //验证当前手机
    function check_cur_mobile(mobile, smscode, callback) {
    $.getJSON("user_api.html", {act:'check_cur_mobile',mobile:mobile,smscode:smscode}, function(res){
    if (typeof callback === "function"){
    callback(res);
    };
    });
    }

    //领取优惠券
    function receive_coupon(coupon_id, btn) {
    $.getJSON("quan.html", {act:'receive_coupon',coupon_id:coupon_id}, function(res){
    if (typeof callback === "function"){
    callback(res);
    }
    else
    {
    if(res.url) {
    window.location.href = res.url;return;
    }
    else if(res.err && res.err !='') {
    msg("领取失败，" + res.err);return;
    }
    msg("领取成功", 5000);
    btn.replaceWith('<i class="quan-ico quan-geted"></i>');
    }
    });
    }
    //领取优惠券
    $(".couponlist").on("click", ".getcoupon", function() {
    receive_coupon($(this).data("id"), $(this));
    });

    </script>

<script>
    产品页面
    //加入购物车点击事件
    $('#addToCate').click(function(){
        getSpec();
        if(!checkHasSpec()){

            alert("请选择商品规格");
            return false;
        }

        var spec = haveSpec.join(',');
        console.log(haveSpec);
        var url='{{url('home/cart/add')}}';
        var gid='{{$productInfo->id}}';
        var num =$('.n_ipt').val();
        $.get(url,{'gid':gid,'num':num,'spec':spec},function(data){
            if(data.status == 0){
                //处理成功
                var msg = data.message;
                var data = data.cartTotal;
                $('#msg').html(msg);
                var str = "购物车共有"+data.type+"种宝贝（"+data.count+"件）&nbsp;&nbsp;合计"+data.total+"元";
                $('#data').html(str);

                ShowDiv_1('MyDiv1','fade1');
            }else{
                //
                var msg = data.message;
                //  $('#msg').html(msg);
                if(data.status == 20){
                    ShowDiv('MyDiv_login','fade_login');
                }
            }
            console.log(data);
        } ,'json')
    })


    function addUpdate1(jia,id){
        var c = jia.parent().find(".car_ipt").val();
        c=parseInt(c)+1;
        jia.parent().find(".car_ipt").val(c);
        c=c*'{{$value['price']}}';
    jia.parent().parent().next().children('span').html(c);
    var sum = ($('.fr b').html()-0)+('{{$value['price']}}'-0);
    $('.fr b').html(sum);

}

function jianUpdate1(jian,id){
    var c = jian.parent().find(".car_ipt").val();
    if(c==1){
        c=1;
    }else{
        c=parseInt(c)-1;
        jian.parent().find(".car_ipt").val(c);
    }
    c=c*'{{$value['price']}}';

   jian.parent().parent().next().children('span').html(c);
   c= '{{$value['price']}}';
    var sum = ($('.fr b').html()-0)-('{{$value['price']}}'-0);
    $('.fr b').html(sum);
}


</script>

<script>
    $(function() {
    setTimeout(function() {
    $("#goods-spec .it .select-mod").each(function() {
    $(this).children("a").eq(0).trigger("click");
    });
    },10);

    $("#goods-spec .it a").each(function() {
    $(this).click(function() {
    if ($(this).data("img") !='') {
    var imgs = $(this).data("img");
    var html ='';
    if(imgs) {
    $.each(imgs, function(k, v) {
    html +='<li><a rel="bigimg" rev="'+v.img+'"><img src="'+v.thumb+'"></a></li>';
    })
    }

    $("#imglist").html(html);
    $(".slide-fish ul.smallImg").children("li").eq(0).find("img").trigger("mouseover");
    }
    });
    });

    })

    var goods_id = $("#goods_id").val();
    var time =0;
    //回复
    function reply(th) {
    if (time != 0) {
    msg("请别回复太快哦"); return;
    }
    var t = $(th),txt = t.parent().siblings().children(".textpj");
    var reply = txt.attr("placeholder"),
    content = $.trim(txt.val()),
    pid = t.data("pid"),
    ptype = t.data("ptype"),
    cid = t.parents("li").attr("id");

    if(content =='')
    {
    msg('请输入回复内容');
    return;
    }

    $.getJSON("/user.html", {act:'add_comment_reply', gid: goods_id, pid: pid,ptype: ptype, content: content,cid:cid}, function(res) {
    if(res.err && res.err != '') {
    msg('操作失败，' + res.err);return;
    }
    if(res.url && res.url != '') {
    window.location.href = res.url; return;
    }
    else
    {
    var html= '<div class="receive"><p><span class="user-name">yunec '+reply+'：</span>'+content+'</p></div>';
    if (ptype==1) {
    t.parents(".replylist").append(html);
    } else{
    t.parents(".receivebox").siblings(".replylist").append(html);
    }
    t.parents(".receivebox").hide().find(".textpj").val('');
    var n = t.parents(".personeva").children().children("a").children("em");
    n.html(parseInt(n.html())+1);
    time =60;
    var ti =setInterval(function() {
    if (time == 0) {
    clearInterval(i);return;
    }
    time--;
    },1000);
    }
    });
    };

    $(".ul-pro-box li").each(function(){
    if($(this).index()%4==3){
    $(this).css("margin-right","4px");
    }
    if($(this).index()%4==0){
    $(this).css("margin-left","4px");
    }
    });

    //获取回复
    function get_reply(t){
    if ($(t).siblings(".replylist").hasClass("loaded")==false) {
    var cid = $(t).parents("li").attr("id");
    $.getJSON("/user.html", {act:'get_comment_reply', cid:cid}, function(res) {
    if(res.err && res.err != '') {
    }
    else
    {
    var html='';
    $.each(res.data, function(k, v) {
    html += '<div class="receive"><div class="content"><span class="user-name">'+ v.uname +' 回复 '+ v.reply_name+'：</span><span>'+ v.content+'</span><p><a href="javascript:void(0);" onclick="javascript:show_replybox(this);" class="receivea">回复</a></p></div><span style="float:right;">'+ v.addtime +'</span>';
        html += '';
        html += '<div class="rec-box"><div class="inner"><textarea placeholder="回复 '+ v.uname +':" class="textpj" onkeyup="words_deal(this);" maxlength="120"></textarea></div>';
            html += '<p> <span>还可以输入<em>120</em>字</span> <input type="submit" data-pid="'+v.id+'" data-ptype="1" value="提交" class="submita" onclick="javascript:reply(this);"/> </p></div></div>';
    html += '</div>';
    });
    $(t).siblings(".replylist").append(html).addClass("loaded");
    }
    });
    }
    show_replybox(t);
    };

    //显示回复框
    function show_replybox(th) {
    var t =$(th);
    t.siblings(".receivebox,.replylist").toggle();
    t.parents(".content").siblings(".receivebox").toggle();
    t.toggleClass("showvisi");
    }

    //
    $(".evalute-titleul li").each(function(){
    var t = $(this);
    t.click(function(){
    t.addClass("check").siblings().removeClass("check");
    t.find("em").addClass("embold").siblings().removeClass("embold");
    var level =t.data("level"),
    page = t.data("page");

    //加载评价数据
    if (t.hasClass("loaded")==false) {
    loadComment(t,level,page);
    }
    });
    });

    //加载更多评价
    $(".loadmore").click(function() {
    var t = $(".evalute-titleul").children().eq($(this).parents(".evalute-detail").index());
    var level =t.data("level"),
    page = t.data("page");
    loadComment(t,level,page);
    });

    function loadComment(t,level,page) {
    $("#"+(level==''?'all':level)).children(".loading").show();
    $.getJSON("/user.html", {act:'get_comment', id:goods_id, level: level,page: page}, function(res) {
    if(res.err && res.err != '') {

    }
    else
    {
    var html='';
    $.each(res.data, function(k, v) {
    html +='<li id="'+ v.id +'"><div class="column starevalute">';
            html +='<div class="column rankevalute"><div class="member"><img src="'+(v.uimg!=''? v.uimg :'./view/default/images/avatar.jpg')+'" alt="" /></div>';
                //html +='<span class="red">'+ v.grade_name +'</span>';
                html +='<div class="menber-rank"><span>'+ v.anon_name +'</span></div></div>';
            html +='<div class="grade-stars grade'+ v.star +'"></div><p> '+ v.addtime +' </p></div>';
        html +='<div class="column personeva"><div class="comment">'+ v.content;
                if (v.thumb && v.thumb.length>0) {
                html +='<div class="show-pic"><dl>';
                        $.each(v.thumb, function(key, val) {
                        html +='<dd><a data-src="'+v.img[key]+'"><img src="'+val+'" width="80" height="80"/></a></dd>';
                        });
                        html+='</dl></div><div class="sc_picbox"><div class="sc_pictab"><a href="javascript:void(0);" class="a_up"><em class="icon-up"></em>收起</a><a href="javascript:void(0);" class="a_left"><em class="round-left"></em>向左旋转</a><a href="javascript:void(0);" class="a_right"><em class="round-right"></em>向右旋转</a></div><div class="sc_photo"><img src="'+v.img[0]+'" alt="" class="dyimg_src"/></div></div>';
                }
                html +='</div><div class="receive"><a href="javascript:void(0);" onclick="javascript:get_reply(this);" class="receivea showvisi">回复(<em>'+ v.reply_count +'</em>)</a>';
                html +='<div class="receivebox">';
                    html +='<div class="inner"><textarea placeholder="回复 '+ v.anon_name +':" class="textpj" onkeyup="words_deal(this);" maxlength="120"></textarea></div>';
                    html +='<p> <span>还可以输入<em>120</em>字</span> <input type="submit" data-pid="'+ v.id +'" data-ptype="0" value="提交" class="submita" onclick="javascript:reply(this);" /> </p></div>';
                html +='<div class="replylist"></div></div></div></li>';
    });

    level= level==''?'all':level;
    $("#"+level).children("ul").append(html);
    t.data("page",page + 1);
    if (t.hasClass("loaded")==false) {
    t.addClass("loaded");
    }
    if (res.data.length==0 || (res.res && res.res==1)) {
    $("#"+level).children(".pages").html("没有更多评价了~");
    }
    inti_showpic();
    }
    $("#"+level).children(".loading").hide();
    });
    }

    $(".tab-gbw").slide({trigger:"click"});
    $(".slide-detail .hdd li").each(function(){
    $(this).click(function(){
    $(this).addClass("on").siblings().removeClass("on");
    if($(this).index()==0){
    $(".box1detail,.otherbox,.evalute,.box1 h3.title").show();
    }
    else if($(this).index()==1)
    {
    $(".box1detail,.otherbox").hide();
    $(".evalute").show();
    $(".box1 h3.title").hide();
    }
    else{
    $(".box1detail,.evalute").hide();
    $(".otherbox").show();
    $(".box1 h3.title").hide();
    }
    });
    });

    $(".pps li:last-child").css("border-bottom","none");
    $(document).ready(function() {
    loadLayer();

    $(".slide-fish").slide({ titCell:".smallImg li", mainCell:".bigImg", effect:"left", autoPlay:false,delayTime:200});
    $(".slide-fish .small-scroll").slide({mainCell:"ul.smallImg",effect:"left",autoPlay:false ,autoPage: true,vis: 5,delayTime:100});
    $(".slide-fish ul.smallImg").on("mouseover","li img", function() {
    $(this).parents("li").css("border-color","#de342f").siblings().css({"border-color":"#fff"});
    var s=$(this).parents(".small-scroll").siblings(".t2").children();
    s.children(".main_img").prop("src", $(this).parent().prop("rev"));
    s.children(".MagicZoomBigImageCont").find("img").prop("src", $(this).parent().prop("rev"));
    });
    });
    $(".slider-protj").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"top",autoPlay:false,vis:2});
    $(window).scroll(function(){
    var topproview=$(".pro-view").outerHeight()+$(".header").height();
    if($(window).scrollTop()>topproview){
    $(".pro-tab .hdd").addClass("hdfix");
    }
    else{
    $(".pro-tab .hdd").removeClass("hdfix");
    }
    });





    $(function() {

        $("input[name='status']").change(function() {
            if ($(this).val() == '8') {
                $("#mod-refund").show();
            }
            else{
                $("#mod-refund").hide();
            }
        });

        $("#create-refund").click(function() {
            var t = $("#create-refund");
            var refund_fee = $.trim($("#refund_fee").val()), saleprice = $("#saleprice").html();
            refund_fee = refund_fee==''? 0 : parseFloat(refund_fee);
            saleprice = saleprice==''? 0 : parseFloat(saleprice);
            if (refund_fee =='' || refund_fee=='') {
                msg("请先填写退款金额");
                return false;
            }
            if (refund_fee >saleprice) {
                msg("退款金额不能大于商品金额");
                return false;
            }

            $.getJSON("./admin.html?do=service", {act:'add_refund',id: 4, order_sn:18061457100100, refund_fee:refund_fee}, function (r) {
                if (r.err) {
                    msg(r.err);return;
                }
                msg("生成成功");
                $("#refund_no").val(r.data.refund_no);
                $("<span>退款单号：" + r.data.refund_no + "&nbsp;&nbsp;</span>").insertBefore(t);
                if (r.data.refund_html !='') {
                    t.replaceWith(r.data.refund_html);
                    //t.attr({"href":r.data.refund_html, 'target':'_blank'}).html("确认退款").unbind("click");
                } else{
                    t.html("确认退款").attr("data-paycode", r.data.pay_code).unbind("click").bind('click', function() {
                        addRefund(r.data.refund_no,refund_fee, t);
                    });
                }
            });
        });
    });

    function addRefund(refund_no,refund_fee, t)
    {
        $.getJSON("./admin.html?do=service", {act:'apply_refund', refund_no:refund_no, order_sn:18061457100100, refund_fee:refund_fee}, function (r) 			{
            if (r.err) {
                msg(r.err);return;
            }

            if (r.data.trade_msg && r.data.trade_msg!='') {
                msg(r.data.trade_msg);
                $("#msg").html("退款失败：" + r.data.trade_msg);
                return;
            }
            msg("退款成功");
            $("#msg").html('<b class="green">退款成功！</b>');
            $("#btnreturn").remove();
        });
    }

    var ok=false;
    function check(th) {
        if (ok) {
            return true;
        }
        if ($("input[name='status']:checked").val() == '8') {
            var refund_fee = $.trim($("#refund_fee").val()), saleprice = $("#saleprice").html();
            refund_fee = refund_fee==''? 0 : parseFloat(refund_fee);
            saleprice = saleprice==''? 0 : parseFloat(saleprice);
            if (refund_fee >saleprice) {
                msg("退款金额不能大于商品金额");
                return false;
            }
            if (refund_fee >0 && $("#refund_no").val() =='') {
                msg("您填写了退款金额，请先生成退款单");
                return false;
            }

            top.layer.confirm("确定处理完成吗", function(index) {
                ok = true;
                top.layer.close(index);
                $("#form_service").submit();
            });
            return false;
        }
        return true;
    }


    $(document).ready(function(){
        $("#start_date,#end_date" ).datetimepicker({showTimepicker:false});

        query_total();//累计销售金额

        var myChart = echarts.init(document.getElementById('chart')),amountChart = echarts.init(document.getElementById('chart-amount'));

        option = {
            title: {
                text: ''
            },
            tooltip: {
                trigger: 'axis',
                formatter:function(a) {
                    return a[0].data;
                }
            },
            legend: {
                data:['销售数量']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                x:"90%",
                feature: {
                    mark : {show: true},
                    magicType : {show: true, type: ['line', 'bar']},
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: []
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'销售数量',
                    type:'line',
                    stack: '总量',
                    data:[]
                }
            ]
        };

        optionAmount = {
            title: {
                text: ''
            },
            tooltip: {
                trigger: 'axis',
                formatter:function(a) {
                    return a[0].data+"单";
                }
            },
            legend: {
                data:['销售']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                x:"90%",
                feature: {
                    mark : {show: true},
                    magicType : {show: true, type: ['line', 'bar']},
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: []
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'订单数',
                    type:'line',
                    stack: '总量',
                    data:[]
                }
            ]
        };

        myChart.setOption(option);

        query_salenum();//加载图表数据

        $("#query").click(function() {
            query_salenum();
        });

//ui-datepicker-close
        $("#start_date,#end_date").change(function() {
            query_salenum();
        });

        $(".btn-groupby label").click(function() {
            $(".op-date").children().eq($(this).index()).show().siblings().hide();
            query_salenum();
            top.setIframeHeight();

        });

        $(".ladder-mod .it-list span").click(function() {
            query_salenum();
        });

        function query_total() {
            $.getJSON("admin.html?do=stat_sale", {act:"get_total"}, function(res) {
                $("#total_amount").html(res.data.amount);
                $("#total_num").html(res.data.num);
            });
        }

        function query_salenum() {
            var groupby = $("input[name='groupby']:checked").val(),
                year =0,
                month=0;
            switch (groupby){
                case 'year':
                    year = $("#year-y").val();
                    break;
                case 'month':
                    year = $("#month-y").val();
                    month = $("#month-m").val();
                    break;
                case 'day':
                    break;
                default:
                    break;
            }

            myChart.showLoading({text: '正在拼命读取数据...'});
            $.getJSON("admin.html?do=stat_sale", {act:"get_sale",groupby:groupby,year:year,month:month, start_date:$("#start_date").val(), end_date:$("#end_date").val()}, function(res) {
                myChart.hideLoading();
                myChart.setOption({
                    xAxis: {
                        data: res.data.cat
                    },
                    series: [{
                        name:'订单数',// 根据名字对应到相应的系列
                        type:'line',
                        stack: '总量',
                        data: res.data.data
                    }]
                });
            });
        }

    });

</script>
</html>
