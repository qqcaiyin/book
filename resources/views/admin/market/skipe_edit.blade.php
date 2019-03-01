@extends('admin.master')
<style>

    .table1 tr{
        border-collapse: collapse;
        border:1px solid #e2e2e2;
    }
    .table1 ,td{
        border:0px;
    }
</style>
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 营销 <span class="c-gray en">/</span> 营销管理 <span class="c-gray en">/</span>抢购添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <form  method="get" name="form1"   action="" >
        <input  type="hidden" name="sid" id="sid"  value="{{$skipedetails->id}}"    >
        <div class="cl pd-5  mt-20" >
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">活动名称：</sapn>
            <input   id="name" tyep="text"  style=" height:28px; width:400px;"  value="{{$skipedetails->name}}"    autocomplete="off"  >
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">是否启用：</sapn>
                <input type="radio" id="enable" name="enable"  @if($skipedetails->enable==1) checked @endif  value="1"><label for="enable">是</label>
                <input type="radio" id="enable" name="enable"  @if($skipedetails->enable==0) checked @endif   checked  value="0"><label for="enable">否</label>
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">活动时间：</sapn>
                <input type="text" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="logmax" class="input-text Wdate"    name="starttime"  style="width:180px;"  autocomplete="off"  value="{{ date('Y-m-d H:i:s',$skipedetails->starttime ) }}">
                -
                <input type="text"   name="endtime"onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss' })" id="logmin" class="input-text Wdate" style="width:180px;"  autocomplete="off"  value="{{ date('Y-m-d H:i:s',$skipedetails->endtime ) }}">
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">优惠方式：</sapn>
                <input type="radio" id="ty" name="ty" @if($skipedetails->ty==1) checked @endif    value="1"><label for="ty">统一价</label>
                <input type="radio" id="ty" name="ty" @if($skipedetails->ty==2) checked @endif   value="2"><label for="ty">直减</label>
                <input type="radio" id="ty" name="ty" @if($skipedetails->ty==3) checked @endif   value="3"><label for="ty">折扣</label>
                <input  tyep="text"  id="val" style=" height:28px; width:100px;"  autocomplete="off"  value="{{$skipedetails->val}}"  >
                <label style="color:#bbb;"> 1、统一价：所选商品统一价格。2、直减：在价格基础直减。3、折扣：在价格基础打折，请填写小数，如八五折填写0.85。  </label>
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">指定会员：</sapn>
                <input type="checkbox" id="ty" name="enable[]" value="1"><label for="enable">黄金</label>
                <input type="checkbox" id="enable" name="enable[]" value="0"><label for="enable">青铜</label>
                <label style="color:#bbb;"> 指定等级的会员可参与该活动，全选或全不选表示所有会员。 </label>
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">商品选择：</sapn>
                <span style=" display: inline-block; height:40px; width:120px; border:1px solid red; text-align: center; vertical-align: middle;  line-height: 40px; border-radius: 4px; cursor: pointer;"onclick="pdt_show('','/admin/pdt','900','580')" >选择商品</span>
                <label style="color:#bbb;">已选<sapn id="num" style="color:red;"> {{$skipedetails->num}}</sapn> 件 </label>
                <input  type="hidden" id="good_ids" name="good_ids"  value="{{$skipedetails->good_ids}}">
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd; ">
                <sapn style="display: inline-block; width:150px;  text-align: right; vertical-align: top;">活动描述：</sapn>
               <textarea   id="des" style=" width:50%; height:100px;"> {{$skipedetails->des}}</textarea>
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd; ">
                <sapn style="display: inline-block; width:150px;  text-align: right;"></sapn>
                <span  id="sub"     style=" display: inline-block; height:30px; width:80px; border:1px solid #007cc3; text-align: center; vertical-align: middle;  line-height: 30px; border-radius: 4px;cursor: pointer; " >提交</span>
                <a href="{{url('/admin/market/skipe')}}"   style=" display: inline-block; height:30px; width:80px; border:1px solid #007cc3; text-align: center; vertical-align: middle;  line-height: 30px; border-radius: 4px; cursor: pointer; text-decoration: none" >返回</a>
            </p>

        </div>
    </form>
</div>




@endsection

@section('my-js')

    <script type="text/javascript">

        //选择产品
        function pdt_show(title,url,width,height){
            layer_show(title,url,width,height);
        }
        //提交
        $('#sub').click(function(){
            if($.trim($('#name').val()) == '' ){
                layer.msg('请填写名称', {time:2000});
                return ;
            }
            if($.trim($('input[name=starttime]').val()) == '' ){
                layer.msg('请选择活动开始时间', {time:2000});
                return ;
            }
            if($.trim($('input[name=endtime]').val()) == '' ){
                layer.msg('请选择活结束时间', {time:2000});
                return ;
            }
            if($.trim($('#val').val()) == '' ){
                layer.msg('请填写优惠值', {time:2000});
                return ;
            }
            if($.trim($('#good_ids').val()) == '' ){
                layer.msg('请选择商品', {time:2000});
                return ;
            }

            var id = $.trim($('#sid').val());
            var name = $.trim($('#name').val());
            var enbale = $('input[name=enable]:checked').val();
            var starttime = $.trim($('input[name=starttime]').val());
            var endtime = $.trim($('input[name=endtime]').val());
            var ty = $('input[name=ty]:checked').val();
            var val = $.trim($('#val').val());
            var good_ids = $.trim($('#good_ids').val());
            var des = $.trim($('#des').val());

            $.get('/admin/service/market',{
                act:'edit_skipe',
                id:id,
                name:name,
                enbale:enbale,
                starttime:starttime,
                endtime:endtime,
                ty:ty,
                val:val,
                good_ids:good_ids,
                des:des
            },function(res){
                if(res.status==0){
                    location.href ='/admin/market/skipe';
                }
                layer.msg(res.message, {time:2000});

            },'json');







        })






    </script>

@endsection