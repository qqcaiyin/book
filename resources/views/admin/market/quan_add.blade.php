@extends('admin.master')
<style>


    .input-mi{
        border: 1px solid #ddd;
        outline:none;
        width:60px;
        height:30px;
        text-align:left;
        display:inline;
        border-radius:5px;
    }


</style>
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 营销 <span class="c-gray en">/</span> 优惠券 <span class="c-gray en">/</span>添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <form  method="get" name="form1"   action="{{url('/admin/balance/log_search')}}" >
        <div class="cl pd-5  mt-20 " >
            <p  class="distrib-open" style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">券名：</sapn>
                <input  id="name"  type="text" class="input-mi"  style="width: 200px;"  >
            </p>
            <p  class="distrib-open" style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">面值：</sapn>
                <input  id="parvalue"  type="text" class="input-mi"   onchange="onlyNum(this)" > &nbsp;元
            </p>
            <p  class="distrib-open" style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">兑换所需积分：</sapn>
                <input  id="needpoint"  type="text" class="input-mi"   onchange="onlyNum(this)" value="0" > 个积分
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">使用条件：</sapn>
                满
                <input  tyep="text"  id="amount_reached"  name="amount_reached"   class="input-mi"  onchange="onlyNum(this)" value="100"  >&nbsp;
                <label >  元使用</label>
            </p>
            <p style="width: 100%; padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">发放方式：</sapn>
                <input type="radio" id="get_type" name="get_type" checked  value="0"><label for="enable">买家领取</label>
                <input type="radio" id="get_type" name="get_type"    value="1"><label for="enable">后台发放</label>
            </p>

            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">有效时间：</sapn>
                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="logmax" class="input-text Wdate"    name="start_time"  style="width:180px;"  autocomplete="off" >
                -
                <input type="text"   name="end_time"onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss' })" id="logmin" class="input-text Wdate" style="width:180px;"  autocomplete="off" >
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">限领：</sapn>
                <label >每人限领  &nbsp;</label>
                <input  tyep="text"  id="user_limit_num" class="input-mi"  onchange="onlyNum(this)" value="1"  >&nbsp;&nbsp;张，
                <label >每人每天限领  &nbsp;</label>
                <input  tyep="text"  id="user_day_num" class="input-mi"  onchange="onlyNum(this)" value="1"  >&nbsp;&nbsp;张
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">适用范围：</sapn>
                <input type="radio" id="limitation" name="limitation" value="0"><label for="enable">全场</label>
                <input type="radio" id="limitation" name="limitation"  checked  value="1"><label for="enable">类别</label>
                <input type="radio" id="limitation" name="limitation"  checked  value="2"><label for="enable">商品</label>
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">商品选择：</sapn>
                <span style=" display: inline-block; height:40px; width:120px; border:1px solid red; text-align: center; vertical-align: middle;  line-height: 40px; border-radius: 4px; cursor: pointer;"onclick="pdt_show('','/admin/pdt','900','580')" >选择商品</span>
                <label style="color:#bbb;">已选<sapn id="num" style="color:red;"> 0</sapn> 件 </label>
                <input  type="hidden" id="cate_good_ids" name="cate_good_ids"  value>
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">指定会员：</sapn>
                <input type="checkbox" id="ty" name="enable[]" value="1"><label for="enable">黄金</label>
                <input type="checkbox" id="enable" name="enable[]" value="0"><label for="enable">青铜</label>
                <input type="checkbox" id="ty" name="enable[]" value="1"><label for="enable">全员</label>
                <label style="color:#bbb;"> 指定等级的会员可参与该活动，全选或全不选表示所有会员。 </label>
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">状态：</sapn>
                <input type="radio" id="is_enable" name="is_enable" value="0"><label for="enable">开启</label>
                <input type="radio" id="is_enable" name="is_enable"  checked  value="1"><label for="enable">停用</label>
            </p>

            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd; ">
                <sapn style="display: inline-block; width:150px;  text-align: right;"></sapn>
                <span  id="sub"     style=" display: inline-block; height:30px; width:80px; border:1px solid #007cc3; text-align: center; vertical-align: middle;  line-height: 30px; border-radius: 4px;cursor: pointer; " >提交</span>
                <a href="{{url('/admin/market/quan_list')}}"   style=" display: inline-block; height:30px; width:80px; border:1px solid #007cc3; text-align: center; vertical-align: middle;  line-height: 30px; border-radius: 4px; cursor: pointer; text-decoration: none" >返回</a>
            </p>

        </div>
    </form>
</div>




@endsection

@section('my-js')

    <script type="text/javascript">

        function onlyNum(t) {
            t.value = t.value.replace(/[^\d]/g, '');//  /[^\d\.]/g
            var n =  parseInt($.trim($(t).val()) ) ;
            var expire = isNaN(n)? 1: n;
            $(t).val(expire);
        }
        //选择产品
        function pdt_show(title,url,width,height){
            layer_show(title,url,width,height);
        }

        //提交
        $('#sub').click(function(){

            var name = $.trim($('#name').val());  //优惠券名字
            var parvalue =  parseInt($.trim($('#parvalue').val()) ) ; //面值
            var needpoint =  parseInt($.trim($('#needpoint').val()) ) ; //面值
            var amount_reached =  parseInt($.trim($('#amount_reached').val()) ) ; //面值
            var user_limit_num =  parseInt($.trim($('#user_limit_num').val()) ) ; //每人限领
            var user_day_num =  parseInt($.trim($('#user_day_num').val()) ) ; //每人每天限领
            var get_type = $('input[name=get_type]:checked').val();  //获取方式
            var is_enable = $('input[name=is_enable]:checked').val();  //状态
            var limitation = $('input[name=limitation]:checked').val();  //状态
            var start_time = $.trim($('input[name=start_time]').val());
            var end_time = $.trim($('input[name=end_time]').val());
            var cate_good_ids = $.trim($('#cate_good_ids').val());  //选择的类别和商品

            if(name == '' ){
                layer.msg('请填写名称', {time:2000});
                return ;
            }
            if( isNaN(parvalue) ){
                layer.msg('填写面值', {time:2000});
                return ;
            }
            if(isNaN(amount_reached)  ){
                layer.msg('填写使用条件', {time:2000});
                return ;
            }
            if(isNaN(amount_reached)  ){
                layer.msg('填写使用条件', {time:2000});
                return ;
            }
            if(isNaN(user_limit_num)  ){
                layer.msg('请填写限购数量', {time:2000});
                return ;
            }
            if(start_time == ''|| end_time == ''  ){
                layer.msg('请填写有效时间', {time:2000});
                return ;
            }
            if(limitation!=0 &&  cate_good_ids =='' ){
                layer.msg('请选择优惠的类别或商品', {time:2000});
                return ;
            }



            $.get('/admin/service/market',{
                act:'add_quan',
                name:name,
                parvalue:parvalue,
                needpoint:needpoint,
                amount_reached:amount_reached,
                get_type:get_type,
                start_time:start_time,
                end_time:end_time,
                user_limit_num:user_limit_num,
                user_day_num:user_day_num,
                limitation:limitation,
                cate_good_ids:cate_good_ids,
                is_enable:is_enable
            },function(res){
                if(res.status==0){
                    location.href='/admin/market/quan_list';
                }

                layer.msg(res.message, {time:2000});

            },'json');

        })






    </script>

@endsection