@extends('admin.master')
<!--引入百度富文本-->
<script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/ueditor.all.min.js')}}"> </script>
<script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/lang/zh-cn/zh-cn.js')}}"></script>


@section('content')

<div class="page-container">
	<form class="form form-horizontal" id="form-product-add"   onsubmit="product_save()"  name="form-product-add"    method="post" action="{{url('/admin/service/product/edit')}}"  >
        <input name="pid" value="{{$product->id}}"  style="display:none ;">
        {{csrf_field()}}
		<div id="tab-system" class="HuiTab">
			<div class="tabBar cl">
				<span>通用信息</span>
				<span>详细描述</span>
				<span>产品相册</span>
				<span>产品属性</span>
			</div>
			<div class="tabCon">
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						产品名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="name"  id="website-title"   class="input-text" value="{{$product->name}}">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						产品货号：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="product_sn"  id="website-Keywords" class="input-text" style="width:300px;" value="{{$product->product_sn}}">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						产品类别：</label>
					<div class="formControls col-xs-8 col-sm-9">
					<span class="select-box" style="width:300px;">
			            <select class="select" name="category_id" size="1" >
				            <option value="0">无</option>
							@foreach($cates as $cate)
								@if($cate->id == $product->category_id)
									<option selected value="{{$cate->id}}">{{$cate->name}}</option>
								@else
									<option  value="{{$cate->id}}">{{$cate->name}}</option>
								@endif
							@endforeach
			            </select>
			        </span>
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2" >
						<span class="c-red">*</span>
						价格：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:200px;">
						<input type="" name="price" id="website-description" placeholder=" 价格"  class="input-text" value="{{$product->price}}">
					</div>
					<label class="form-label col-xs-4 col-sm-2" >
						折扣：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:150px;">
						<input type="text" name="discount"  id="website-description" placeholder=" 折扣" value="1" class="input-text"  value="{{$product->discount}}">
					</div>
				</div>
				<div class="row cl">
					<span class="c-red">*</span>
					<label class="form-label col-xs-4 col-sm-2">商品库存数量：</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:200px;">
						<input type="text"  class="input-text" id="" name="num" value="{{$product->num}}">
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">上架：</label>
					<div class="formControls col-xs-8 col-sm-9" >
						<input type="checkbox" id="is_showbox"  @if($product->is_show) checked @endif value="1">
						<input name="is_show" type="hidden" id="is_show"   @if($product->is_show) value="1"  @else value="0" @endif>
						<label for="sex-1">选中表示上架</label>
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">加入推荐：</label>
					<div class="formControls col-xs-8 col-sm-9">
							<input type="checkbox" id="is_hotbox"  @if($product->is_hot) checked @endif value="1">
							<input name="is_hot" type="hidden" id="is_hot"   @if($product->is_hot) value="1"  @else value="0" @endif>
						<label for="is_hot">热销</label>
							<input type="checkbox" id="is_newbox"  @if($product->is_new) checked @endif value="1">
							<input name="is_new" type="hidden" id="is_new" @if($product->is_new) value="1"  @else value="0"  @endif>
						<label for="is_new">新品</label>
							<input  type="checkbox" id="is_bestbox"   @if($product->is_best) checked @endif value="1">
							<input name="is_best" type="hidden" id="is_best" @if($product->is_best) value="1"  @else value="0" @endif>
						<label for="is_best">精品</label>
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">促销：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input   type="checkbox" id="is_salebox" @if($product->is_sale)  checked @endif  value="1">
						<input name="is_sale" type="hidden" id="is_sale" @if($product->is_sale) value="1"  @else value="0" @endif>
						<label >促销&nbsp;&nbsp;&nbsp;</label>
						<input type="text" onfocus="WdatePicker()" id="logmin" class="input-text Wdate"  name=" start_date"  autocomplete="off"  style="width:120px;"  value="@if(!empty($product->start_date)){{ date('Y-m-d',$product->start_date)}}  @endif" >
						-
						<input type="text"  onfocus="WdatePicker()" id="logmax" class="input-text Wdate"  name="end_date"    autocomplete="off" style="width:120px;"  value="@if(!empty($product->end_date)){{date('Y-m-d',$product->end_date)}}  @endif">
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2" >
						促销价：
					</label>
					<div class="formControls col-xs-8 col-sm-9" style="width:150px; float:left;">
						<input type="text" name="sale_price"  id="website-description"  value="{{$product->sale_price}}" class="input-text">
					</div>
				</div>

				<div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
                    <div class="formControls col-xs-8 col-sm-9" >
                        <img id="preview_id"  src="{{url($product->preview)}}" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id').click()" />
                        <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','img','images', 'preview_id');" />
                        <input type="text"  name="preview" id="img"  style="display: none;" value="{{$product->preview}}">
                    </div>
                </div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">商品关键词：</label>
					<div class="formControls col-xs-8 col-sm-9" >
						<input type="text"  name="keywords" class="input-text"  placeholder="每个关键词用逗号分隔：笔记本，15''"   value="{{$product->keywords}}">
					</div>
				</div>
				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">商品简介：</label>
					<div class="formControls col-xs-8 col-sm-9" >
						<textarea name="summary" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" onKeyUp="$.Huitextarealength(this,100)">{{$product->summary}}</textarea>
						<p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
					</div>
				</div>

			</div>
			<div class="tabCon">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">产品详情：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <textarea name="product_content" id="product_desc"  style="height: 500px;"> @if($pdt_content != null){!! $pdt_content->content !!} @endif</textarea>

                    </div>
                </div>

			</div>
			<div class="tabCon">
                <div class="row cl">
					@if(count($pdt_images))
						<label class="form-label col-xs-4 col-sm-2">产品配图：</label>

						<div class="formControls col-xs-8 col-sm-9">
							@foreach($pdt_images as $pdt_image)
								<img id="preview_id{{$pdt_image->image_no}}" src="{{$pdt_image->image_path}}" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id{{$pdt_image->image_no}}').click()" />
								<input type="file" name="file" id="input_id{{$pdt_image->image_no}}" style="display: none;" onchange="return uploadImageToServer('input_id{{$pdt_image->image_no}}','img{{$pdt_image->image_no}}','images', 'preview_id{{$pdt_image->image_no}}');" />
								<input type="text"  name="img[]" id="img{{$pdt_image->image_no}}"  style="display: none;">

							@endforeach
						</div>
					@else
                    <label class="form-label col-xs-4 col-sm-2">产品配图：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<img id="preview_id1"  src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id1').click()" />
						<input type="file" name="file" id="input_id1" style="display: none;" onchange="return uploadImageToServer('input_id1','img1','images', 'preview_id1');" />
						<input type="text"  name="img[]" id="img1"  style="display: none;">
						<img id="preview_id2"  src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id2').click()" />
						<input type="file" name="file" id="input_id2" style="display: none;" onchange="return uploadImageToServer('input_id2','img2','images', 'preview_id2');" />
						<input type="text"  name="img[]" id="img2"  style="display: none;">
						<img id="preview_id3"  src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id3').click()" />
						<input type="file" name="file" id="input_id3" style="display: none;" onchange="return uploadImageToServer('input_id3','img3','images', 'preview_id3');" />
						<input type="text"  name="img[]" id="img3"  style="display: none;">
						<img id="preview_id4"  src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id4').click()" />
						<input type="file" name="file" id="input_id4" style="display: none;" onchange="return uploadImageToServer('input_id4','img4','images', 'preview_id4');" />
						<input type="text"  name="img[]" id="img4"  style="display: none;">
					</div>
					@endif
                </div>

			</div>
			<div class="tabCon">
				<div class="row cl" >
					<label class="form-label col-xs-4 col-sm-2">产品类型：</label>
					<div class="formControls col-xs-8 col-sm-9">
					<span class="select-box" style="width:200px;">
			            <select class="select" name="type_id" id="type_id" size="1" >
                            <option value="0">不分配类型</option>
                            @foreach($pdt_types as $pdt_type)
								@if($product->type_id == $pdt_type->id)
				                	<option  selected value="{{$pdt_type->id}}">{{$pdt_type->name}}</option>
								@else
									<option  value="{{$pdt_type->id}}">{{$pdt_type->name}}</option>
								@endif
                            @endforeach
			            </select>
			        </span>
					</div>
				</div>
                <!-----------用于显示商品类型对应的属性----------->
				<div class="row cl ajaxtest" style="margin-left: 0px;">

				</div>
                <!--------------------------->
            </div>
		</div>
		<div class="row cl ">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button  class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
				<button onClick="layer_close();" class="btn btn-default radius delete" type="reset">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
			</div>
		</div>
	</form>
</div>
@endsection

@section('my-js')

	<script type="text/javascript">
        //实例化百度编辑器
        var ue = UE.getEditor('product_desc');

		//进入页面的时候执行一次，后面不再执行
        window.onload = function(){
            var type_id =  $('select[name=type_id] option:selected').val();
            _ajaxTestShow(type_id);
		}
		//选择类别后，把对应的属性填充到页面
        $('#type_id').on('change',function(){
            var type_id =  $('select[name=type_id] option:selected').val();
            _ajaxTestShow(type_id);
        });


        function _ajaxTestShow(id){
            $.get(
                  "{{ url('/admin/product_add/attributes')}}",
                  {  'id':id , 'product_id':'{{$product->id}}', '_token': "{{csrf_token()}}"},
                   function (html) {
                      $('.ajaxtest').empty();
                       $('.ajaxtest').append( html );
                });
        }


        function  check(){
            var index = parent.layer.getFrameIndex(window.name);
            parent.$('.btn-refresh').click();
            parent.layer.close(index);
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

	//复选框的值  ,未作优化
        $(function(){

            //促销
            $('#is_salebox').click(function(){
                var res = $('#is_salebox').is(':checked');
                if(res){
                   // alert(1);
                    $('#is_sale').val(1);
				}else{
                   // alert(0);
                    $('#is_sale').val(0);
				}
            });
			//	热卖
            $('#is_hotbox').click(function(){
                var res = $('#is_hotbox').is(':checked');

                if(res){
                    $('#is_hot').val(1);
                }else{
                    $('#is_hot').val(0);
                }
            });
            //	新品
            $('#is_newbox').click(function(){
                var res = $('#is_newbox').is(':checked');

                if(res){
                    $('#is_new').val(1);
                }else{
                    $('#is_new').val(0);
                }
            });
            //	精品
            $('#is_bestbox').click(function(){
                var res = $('#is_bestbox').is(':checked');

                if(res){
                    $('#is_best').val(1);
                }else{
                    $('#is_best').val(0);
                }
            });
            //展示
            $('#is_showbox').click(function(){
                var res = $('#is_showbox').is(':checked');

                if(res){
                    $('#is_show').val(1);
                }else{
                    $('#is_show').val(0);
                }
            });


        });

		//关闭子层
        function product_save(){
            window.parent.location.reload();
        }

	</script>
@endsection

