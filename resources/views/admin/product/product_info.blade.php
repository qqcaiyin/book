@extends('admin.master')

@section('content')

    <style>
        .row.cl {
            margin: 20px 0;
        }
    </style>

    <form class="form form-horizontal" action="" method="post">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>书名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                {{$product->name}}
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">图书简介：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea cols="" rows="" class="textarea" name="summary">  {{$product->summary}}</textarea>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">价格：</label>
            <div class="formControls col-xs-8 col-sm-9">
               <p style="color: red;"> ￥{{$product->price}}</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">分类：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <p style=""> {{$product->category->name}}</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">预览图：</label>
            <div class="formControls col-xs-8 col-sm-9">
                @if($product->preview != null)
                    <img id="preview_id" src="{{$product->preview}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;"/>
                @endif
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">详细内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                @if($pdt_content != null)
                {!! $pdt_content->content !!}
                    @else
                    暂未添加
                @endif
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">轮播图片 ：</label>
            <div class="formControls col-xs-8 col-sm-9">

                @foreach($pdt_images as $pdt_image)
                    <img src="{{$pdt_image->image_path}}" style="border: 1px solid #B8B9B9; width: 100px; height: 100px;" />
                @endforeach
            </div>
        </div>
        </div>
    </form>
@endsection