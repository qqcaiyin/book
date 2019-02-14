@extends('admin.master')
<style>

	.table1 tr{
		border-collapse: collapse;
		border:1px solid #e2e2e2;
	}
	.table1 ,th, td{
		border:0px ;
	}
</style>
@section('content')

<div class="page-container">
	<form class="form form-horizontal" id="form-product-add"  name="form-product-add"    method="post" action="{{url('/admin/service/product/add')}}" >
        {{csrf_field()}}
		<div id="tab-system" class="HuiTab">
			<div class="tabBar cl">
				<span>商品信息</span>
				<span>订单配置</span>
				<span>收货人信息</span>
			</div>
			<div class="tabCon">
				<table class="table  table-hover table-bg  table1">
					<thead>
					<tr class="text-c">
						<th></th>
						<th width="50%" style="text-align: left;" >商品名称</th>
						<th width="10%">商品价格</th>
						<th width="10%">商品数量</th>
						<th width="10%">操作</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<tr class="text-c">
						<td></td>
						<td style="text-align: left;" >商品名称</td>
						<td >商品价格</td>
						<td >商品数量</td>
						<td >操作</td>
						<td></td>
					</tr>
					</tbody>
				</table>
				<div class="cl pd-5  "  style="margin-left: 10%;">
        <span class="l">
            <a class="btn btn-primary radius" href="{{url('admin/order_add')}}"><i class="Hui-iconfont">&#xe604;</i> 添加商品</a>
        </span>
				</div>

			</div>
			<div class="tabCon">
				<div class="row cl" >
					<label class="form-label col-xs-4 col-sm-2">配送方式：</label>
					<div class="formControls col-xs-8 col-sm-9">
					<span class="select-box" >
			            <select class="select" name="type_id" id="type_id" size="1" >
                            <option value="0">&nbsp;快递</option>
 							<option value="1">&nbsp;货到付款</option>
			            </select>
					</span>
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						配送运费：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="name"  id="website-title" placeholder="" value="" class="input-text">
						<span style="color:#ddd;" >不填写则系统自动计算运费</span>
					</div>
				</div>
				<div class="row cl" >
					<label class="form-label col-xs-4 col-sm-2">支付方式：</label>
					<div class="formControls col-xs-8 col-sm-9">
					<span class="select-box" >
			            <select class="select" name="type_id" id="type_id" size="1" >
                            <option value="0">&nbsp;请选择支付</option>
 							<option value="1">&nbsp;支付宝支付</option>
							<option value="2">&nbsp;微信支付</option>

			            </select>
					</span>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">是否要发票：</label>
					<div class="formControls col-xs-8 col-sm-9" >
						<input name="fapiao" type="checkbox" id="fapiao"  value="1">
						<input name="fp_flag" type="text" id="fp_flag" style="display: none;"  value="0">
						<label for="sex-1">发票</label>
					</div>
				</div>
				<div class="row cl fapiao-show" style="margin-left: 120px; display:none ">
					<label class="form-label col-xs-4 col-sm-2" style="margin-top: 15px;">
						公司名称：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:300px; margin-top: 15px;">
						<input type="text"  name="name"  id="website-title"  value="" class="input-text">
					</div>
					<label class="form-label col-xs-4 col-sm-2" style="margin-top: 15px;">
						纳税人识别码：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:300px;margin-top: 15px;">
						<input type="text"  name="name"  id="website-title"  value="" class="input-text">
					</div>
					<label class="form-label col-xs-4 col-sm-2" style="margin-top: 15px;">
						注册地址：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:300px;margin-top: 15px;">
						<input type="text"  name="name"  id="website-title"  value="" class="input-text">
					</div>
					<label class="form-label col-xs-4 col-sm-2" style="margin-top: 15px;">
						注册电话：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:300px;margin-top: 15px;">
						<input type="text"  name="name"  id="website-title"  value="" class="input-text">
					</div>
					<label class="form-label col-xs-4 col-sm-2" style="margin-top: 15px;">
						开户银行：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:300px;margin-top: 15px;">
						<input type="text"  name="name"  id="website-title"  value="" class="input-text">
					</div>
					<label class="form-label col-xs-4 col-sm-2" style="margin-top: 15px;">
						银行账号：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:300px;margin-top: 15px;">
						<input type="text"  name="name"  id="website-title"  value="" class="input-text">
					</div>
					<label class="form-label col-xs-4 col-sm-2" style="margin-top: 15px;">
						发票类型：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:300px;margin-top: 15px;">
						<span class="select-box" >
			            <select class="select" name="type_id" id="type_id" size="1" >
                            <option value="0">&nbsp;普通发票</option>
 							<option value="1">&nbsp;增值税发票</option>
			            </select>
						</span>
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						订单备注：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="name"  id="website-title" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">指定送货时间：</label>
					<div class="formControls col-xs-8 col-sm-9" >
						<input name="is_show" type="radio" id="is_show"  checked value="1">
						<label for="sex-1">任意</label>
						<input name="is_show" type="radio" id="is_show"  value="1">
						<label for="sex-1">周一到周五</label>
						<input name="is_show" type="radio" id="is_show"  value="1">
						<label for="sex-1">周末</label>
					</div>
				</div>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						所属用户名：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="name"  id="website-title" placeholder="用户注册名" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						收货人姓名：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="name"  style="border: 2px solid red; " id="website-title" placeholder="填写收货人姓名" value="" class="input-text">
					</div>
				</div>
				<div class="row cl" >
					<label class="form-label col-xs-4 col-sm-2">收货地区：</label>
					<div class="formControls col-xs-8 col-sm-9">
					<span class="select-box" style="width:200px;">
			            <select class="select" name="type_id" id="type_id" size="1" >
                            <option value="0">请选择</option>
			            </select>
			        </span>
						<span class="select-box" style="width:200px;">
			            <select class="select" name="type_id" id="type_id" size="1" >
                            <option value="0"> --</option>
			            </select>
			        </span>
						<span class="select-box" style="width:200px;">
			            <select class="select" name="type_id" id="type_id" size="1" >
                            <option value="0">--</option>
			            </select>
			        </span>

					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						联系手机：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="name"  id="website-title" placeholder="填写手机号码" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						邮编：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="name"  id="website-title" placeholder="填写正确的邮编" value="" class="input-text">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">用户附言：</label>
					<div class="formControls col-xs-8 col-sm-9" >
						<textarea name="summary" cols="" rows="" class="textarea"  placeholder="说点什么.." ></textarea>
					</div>
				</div>

                <!-----------用于显示商品类型对应的属性----------->
				<div class="row cl ajaxtest" style="margin-left: 0px;">

				</div>
                <!--------------------------->
            </div>
		</div>


		<div class="row cl ">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2" align="center">
				<button  type="submit" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
				<button  onClick="layer_close();" class="btn btn-default radius delete" type="reset">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
			</div>
		</div>
	</form>
</div>
@endsection

@section('my-js')

	<script type="text/javascript">


		$('#fapiao').click(function(){
		    var f =$('#fp_flag').val();
		    if(f==1){
                $('#fp_flag').val(0);
                $('.fapiao-show').hide();
			}else{
                $('#fp_flag').val(1);
                $('.fapiao-show').show();
			}

		})

        $('#type_id').on('change',function(){
            var type_id =  $('select[name=type_id] option:selected').val();
            _ajaxTestShow(type_id);
        });


        function _ajaxTestShow(id){
            $.get(
                  "{{ url('/admin/product_add/attributes')}}",
                  {  'id':id ,  '_token': "{{csrf_token()}}"},
                   function (html) {
                      $('.ajaxtest').empty();
                       $('.ajaxtest').append( html );
                });
        }
        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
            $("#tab-system").Huitab({
                index:0
            });
        });



	</script>


@endsection

