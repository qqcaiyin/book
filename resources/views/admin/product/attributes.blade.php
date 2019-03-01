<!--

@foreach($pdt_attrs as $pdt_attr)
    @if($pdt_attr->index == 0)<!--//下拉选择-->
        <div class="row cl" >
            <label class="form-label col-xs-4 col-sm-2">{{$pdt_attr->name}}：</label>
            <div class="formControls col-xs-8 col-sm-9">
					<span class="select-box" style="width:200px;">
			            <select class="select" name="attr[{{$pdt_attr->id}}]" id="type_id" size="1" >
                            <option value="0">不分配类型</option>
                            @foreach($pdt_attr->arr as $p)
                                <option @if(isset($pdt_id_attr) && isset($arr[$pdt_attr->id]))
                                        @if(in_array($p,$arr[$pdt_attr->id]))
                                            selected
                                        @endif
                                         @endif
                                value="{{$p}}">{{$p}}</option>
                            @endforeach
			            </select>
			        </span>
            </div>
        </div>
    @elseif($pdt_attr->index == 1)<!--//复选框-->
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">{{$pdt_attr->name}}：</label>
            <div class="formControls col-xs-8 col-sm-9">
                @foreach($pdt_attr->arr as $key=>$p)
                    <input  type="checkbox"  value="{{$p}}"
                    @if(isset($pdt_id_attr)&& isset($arr[$pdt_attr->id]))
                            @if(in_array($p,$arr[$pdt_attr->id]))
                                @foreach($arr[$pdt_attr->id]  as $k => $v)
                                    @if($v == $p)
                                        checked name="attr[{{$pdt_attr->id}}][{{ $k }}]"
                                    @endif
                                @endforeach
                            @else
                                name="attr[{{$pdt_attr->id}}][{{$key}}]"
                            @endif
                    @endif
                    >

                    <label for="is_hot">{{$p}}</label>
                @endforeach
            </div>
        </div>
    @elseif($pdt_attr->index == 2)<!--//输入框-->

    <div class="row cl">
        <label class="form-label col-xs-4 col-sm-2">{{$pdt_attr->name}}：</label>
        <div class="formControls col-xs-8 col-sm-9" >
            <input type="text" name="attr[{{$pdt_attr->id}}]"  class="input-text"
                   value="@if($arr){{$arr[$pdt_attr->id][0]}}@elseif($pdt_attr->id_value != null){{$pdt_attr->id_value}}@endif"  placeholder="每个关键词用逗号分隔：笔记本，15''" id="" >
        </div>
    </div>


  <!--




    -->
    @endif
@endforeach
