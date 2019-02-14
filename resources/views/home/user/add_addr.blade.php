<!DOCTYPE html>
<html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" rel="stylesheet" href="/home/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/ShopShow.css" />
    <link rel="stylesheet" type="text/css" href="/home/css/MagicZoom.css" />

    <title>我的地址</title>
    <style>
        .add-address-center{
            width:600px;
            height:280px;
            text-align: left;
            border: 1px solid #fff;


        }
        .add-address-center .title{
            height:20px;
            margin: 30px 10px 2px 20px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }

        .addr-box{
            margin: 20px 30px;
        }
        .addr-box label{
            width:100px;
            display:inline-block;
            text-align: right;
        }
        .add-address-center .addr-box .c-red{
            color:red;
        }
        .addr-input{
            width:200px;
            height:25px;
            border: 1px solid #ddd;

        }

        .select-box{
            height:30px;
            width:120px;
            margin-right: 10px;
        }
    </style>
</head>
<body>



    <article class="add-address-center">
        <form method="post" action=" ">
            <input type="hidden"  name="id" id="id" value="{{$formId}}" >
            {{csrf_field()}}
        <div class="title ">新增配送信息</div>
        <div class="addr-box">
            <label class=" "><span class="c-red">*</span>收件人：</label>
            <input type="text" class="addr-input" name="consignee"  id="consignee" value="" required maxlength="20"  autocomplete="off"/>
        </div>
        <div class="addr-box">
            <label class=" "><span class="c-red">*</span>手机号码：</label>
            <input type="text" class="addr-input" name="moble" id="moble"   value="" required maxlength="11" minlength="11"  autocomplete="off"/>
        </div>

            <div class="addr-box">
                <label class=" "><span class="c-red">*</span>所在地区：</label>
                    <select name="region1" id="region1"  class="select-box">
                        <option value="0" > -- 省份 --</option>
                        @foreach($data as $val)
                            <option value="{{$val['provinceID']}}" > -- {{$val['province']}} --</option>
                        @endforeach
                    </select>

        </div>
        <div class="addr-box">
            <label class=" "><span class="c-red">*</span>详细地址：</label>

            <input type="text" class="addr-input" style=" width:350px;" name="district"  id="district" value="" required maxlength="20" autocomplete="off"/>
        </div>
            <div class="addr-box">
                <label class=" "></label>

                <input type="checkbox" name="isdefault"  id="isdefault" value="1"   /> 设为默认地址
            </div>
        <div class="addr-box">
            <label class=" "><span class="c-red"></span></label>
                <input class="btn btn-primary radius"  type="button"  onclick="saveconsignee();"  value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        </div>
        </form>
    </article>



    <!--bengin  bengin -->
    <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>

    <script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
    <script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
    <script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
    <!--End  End -->
    <script type="text/javascript">

        //2级区域显示
        $(function() {
            $(document).on('change',':input[name="region1"]',function(){
                var id = $(this).val();
                var _this = $(this);
                var url = '/home/order/addr/p';
                _this.nextAll().remove();
                if(id == 0){
                    return false;
                }
                $.get(url,{ 'p':id},function(data){
                    if(data.status ==0 ) {
                        //返回成功
                        var str = '<select name="region2"  id ="region2 " class="select-box" > <option value="0" selected>------</option>';
                        $(data.cities).each(function (k,v) {
                            str += '<option value="'+ v.cityID  +'">'+ v.city  +'</option> ';
                        });
                        str += '</select>';
                        _this.after(str);
                    }
                },'json');
            });
        });


        //校验
        //保存收货地址
        function saveconsignee() {
            var id = $.trim($("#id").val()),
                consignee = $.trim($("#consignee").val()),
                mobile = $.trim($("#moble").val()),
                province = $("select[name='region1'] option:selected").val(),
                city = $("select[name='region2'] option:selected").val(),
                district = $.trim($("#district").val()),
                isdefault = $("#isdefault").is(":checked")? 1:0;

            if (consignee=='') {
                layer.msg('请填写收货人', {time:2000});
                return;
            }
            else
            {
                var errorFlag = false;
                if(!is_consignee(consignee)){
                    errorFlag = true;
                }else if(consignee.search(/·{2,}/) > -1){
                    errorFlag = true;
                }
                if(errorFlag){
                    layer.msg('收件人姓名仅支持中文或英语', {time:2000});
                    return;
                }
            }
            if (mobile=='') {
                layer.msg('请填写手机号码', {time:2000});
                return;
            }
            else if (!is_mobile(mobile)) {
                layer.msg('手机号码格式不正确', {time:2000});
                return;
            }

          if(province==0 ||city==0){
              layer.msg('请选择所在地区', {time:2000});
              return;
          }
            if (district=='' || district.length < 3) {
                layer.msg('请填写详细地址', {time:2000});
                return;
            }

            var data={

                member_id:id,
                consignee:consignee,
                moble:mobile,
                province:province,
                city:city,
                district:district,
                is_default:isdefault
            }

            $.get('/service/user',{act:'add_address',data:data},function(data){
                if(data.status == 0){
                    layer.msg('保存成功', {time:2000});
                    parent.location.reload();
                    return;
                }
                else if(data.status ==20){
                    layer.msg('请先登录', {time:2000});
                    setTimeout("window.location.href='/login' ", 2000);
                    return;
                }else{
                    layer.msg(data.status, {time:2000});
                    return;
                }
            },'json');

        }



        function is_consignee(v) {
            return /^(([\u4e00-\u9fa5])([\u4e00-\u9fa5·]){0,10}([\u4e00-\u9fa5]))|([a-zA-Z]([a-zA-Z]|\s){2,20})$/i.test(v);
        }
        //手机号码
        function is_mobile(v) {
            return /^(13|14|15|16|17|18|19)[0-9]{9}$/.test(v);
        }


    </script>
   </body>




   </html>
