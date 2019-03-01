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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 订单 <span class="c-gray en">/</span> 订单管理 <span class="c-gray en">/</span>售后服务详情 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container" >
    <div class="mt-20" style="background-color: red;">
            <div style="background-color: #fff; width:100%; padding:1% 12%;">
                <p >
                    <span>
                        服务单号: &nbsp; <input type="text"  id="return_sn"  readonly="readonly" style="border: none;" value="{{$applydetails['return_sn']}} "  >
                    </span>
                    <span style="margin-left:40px; ">
                        订单号:&nbsp; {{$applydetails['order_sn']}}
                    </span>


                    <span style="margin-left: 30px;">
                           状态 :
                           <b style="margin-left:10px ; color: #0BB20C; font-weight: bolder; font-size: 16px; " >
                              @if($applydetails['status'] == 0)待审核
                               @elseif($applydetails['status'] == 1)
                                   @if($applydetails['shipping_status'] == 0)
                                        审核通过
                                   @elseif($applydetails['shipping_status'] == 1)
                                       用户已邮寄
                                   @elseif($applydetails['shipping_status'] == 2)
                                       卖家已签收
                                   @endif
                               @elseif($applydetails['status'] == 2)审核拒绝
                               @elseif($applydetails['status'] == 3)已取消申请
                               @endif
                           </b>
                       </span>
                    <span style="margin-left: 30px;">
                           申请时间&nbsp; :
                        {{date('Y-m-d H:i:s',$applydetails['apply_time'] ) }}
                       </span>
                </p>
                @if($applydetails['shipping_status'] ==1 )
                    <p style=" width:80%; border:1px solid #ffccaa; background: #fffcf1; padding: 10px;">
                        用户已邮寄：
                        订单号：
                        <input stype="text" readonly="readonly"  style="border: 1px solid #ddd;" value="{{$applydetails['express_sn']}}"   >
                        <a href="javascript:;" style="color:#007cc3; text-decoration:none">查看物流信息</a>
                    </p>
                @endif
                <div style=" width:80%; margin-top: 20px;  border:1px solid #ddd; border-radius: 5px; padding-left: 10px; padding-right: 10px; ">
                    <p style=" border-bottom: 1px dashed #ddd; vertical-align: bottom;">
                        商品：
                        <a>
                            <img  style=" height:80px;width:80px;"  src="{{url($applydetails['preview'])}}">
                        </a>
                        <a  style="vertical-align: bottom;" >
                            {{$applydetails['product_name']}} [{{$applydetails['spec_value']}}]
                        </a>

                    </p>
                    <p style="border-bottom: 1px dashed #ddd;">
                        数量：{{$applydetails['product_num']}}
                    </p>
                    <p style="border-bottom: 1px dashed #ddd;">
                        类型：
                        @if($applydetails['state'] == 1)[换货]
                        @elseif($applydetails['state'] == 2)[退货]
                        @endif
                    </p>
                    <p style="border-bottom: 1px dashed #ddd;">
                        姓名：
                    </p>
                    <p style="border-bottom: 1px dashed #ddd;">
                        手机：
                    </p>
                    <p style="border-bottom: 1px dashed #ddd;">
                        收货地址：
                    </p>
                    <p style="border-bottom: 1px dashed #ddd; padding-bottom: 20px;">
                        <span  >问题描述：</span>
                        {{$applydetails['why']}}
                        <br>
                        @foreach($applydetails['img'] as $img)
                            <img style="width:100px;height:100px; border:1px solid #eee;" src={{url($img['image_path'])}}>
                        @endforeach
                    </p>

                        <p style=" padding-top: 30px;">
                            <span  >处理：</span>

                            <input style="margin-left: 20px;" type="radio" name="status"  id="status" value="1" @if($applydetails['status'] !=0) disabled   @endif >
                            <label for="status"  > 审核通过</label>
                            <input style="margin-left: 20px;" type="radio" name="status"  id="status" value="2" @if($applydetails['status'] !=0) disabled   @endif >
                            <label for="status"  > 审核不通过</label>
                            <input style="margin-left: 20px;" type="radio" name="status"  id="status" value="3"  @if($applydetails['status'] != 1) disabled  @endif >
                            <label for="status"  > 取消</label>
                            <input style="margin-left: 20px;" type="radio" name="status"  id="status" value="4"
                                   @if($applydetails['shipping_status'] != 1) disabled  @endif
                                   @if($applydetails['shipping_status'] == 1) checked  @endif
                            >
                            <label for="status"  > 商品处理</label>
                            <input style="margin-left: 20px;" type="radio" name="status"  id="status" value="5"
                                   @if($applydetails['shipping_status'] != 2) disabled  @endif
                                   @if($applydetails['shipping_status'] == 2) checked  @endif
                            >
                            <label for="status"  > 完成</label>
                        </p>

                        <p id="sign" style="display: none;">
                            <a href="javascript:;" style="display: inline-block;margin-left:40%;  width:70px;height:25px; line-height: 25px; text-align: center; background-color: #007cc3;text-decoration:none;color: #fff; border-radius: 3px;" id="return_sign"> 签收</a>
                        </p>

                        <p  id="refund"   style=" padding-top: 10px; vertical-align: top; display: none">
                           退款：
                           <input type="text" readonly="readonly"  name="return_money"   value="100"  style="width:80px;height:30px; border:1px solid #000;" >元
                            <a style="display: inline-block; margin-left: 15px; height:30px; width:50px; line-height: 30px;text-align: center; border-radius: 3px; border: 1px solid darkred; text-decoration: none;">退款</a>
                            <span style=""   >退款单号：&nbsp;&nbsp;  </span>
                        </p>

                        <p id="audit_content" style=" padding-top:10px;">
                            备注：
                            <textarea id="content"   style="width:60%; height:80px ;vertical-align: top;" ></textarea>
                            <span style=""   >将会在用户的 处理结果 中显示  </span>
                        </p>
                        <p id="tj"><a href="javascript:;" style="display: inline-block;margin-left: 60px;  width:70px;height:25px; line-height: 25px; text-align: center; background-color: #007cc3;text-decoration:none;color: #fff; border-radius: 3px;" id="audit"> 提交</a></p>
                    </div>


                </div>
        </div>

    </div>




    @endsection

    @section('my-js')

        <script type="text/javascript">
         $(function(){

             $('input[name=status]').change(function(){
                 if($('input[name=status]:checked').val() ==5) {
                     $('#sign').hide();
                     $('#refund').show();
                 }else{
                     $('#refund').hide();
                 }
                 if($('input[name=status]:checked').val() ==4) {
                     $('#audit_content').hide();
                     $('#tj').hide();
                 }else{
                     $('#audit_content').show();
                     $('#tj').show();
                 }
             });
             //
             if($('input[name=status]:checked').val() ==5) {
                 $('#sign').hide();
                 $('#refund').show();
             }else{
                 $('#refund').hide();
             }
             if($('input[name=status]:checked').val() ==4) {
                 $('#audit_content').hide();
                 $('#tj').hide();
             }else{
                 $('#audit_content').show();
                 $('#tj').show();
             }

             //审核提交
             $('#audit').click(function(){
                 var sn = $('#return_sn').val();
                 var  st =$('input[name=status]:checked').val();//处理编号
                 var content = $('#content').val();
                 $.get('/admin/service/order',{act:'audit_tj',sn:sn,st:st,content:content},function (res) {
                     if(res.status ==0){
                         layer.msg(res.message, { time:2000});
                         window.location.href='/admin/return_list';
                     }else{
                         layer.msg(res.message, { time:2000});
                     }

                 });
             });

             //快递签收
             $('#return_sign').click(function(){
                 var sn = $('#return_sn').val();
                 var  st =$('input[name=status]:checked').val();//处理编号
                 $.get('/admin/service/order',{act:'audit_sign',sn:sn,st:st},function (res) {
                     if(res.status == 0){
                         location.href=location.href;

                     }
                     layer.msg(res.message, { time:2000});
                 });

             })



         });



        </script>

    @endsection