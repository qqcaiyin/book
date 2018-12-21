@extends('master')

@section('title',$product->name)

@section('content')
    <style>
        *{margin: 0;padding:0; }
        ul{list-style: none;}
        .banner{width: 600px;height: 300px;border: 0px solid #ccc;margin: 0px auto;position: relative;overflow: hidden;z-index: 1;}
        .img{position: absolute;top: 0;left: 0;}
        .des{position: absolute;bottom: 0;left: 0;z-index: -2; background: #0000C2 }
        .des li{float: left;width: 600px;}
        .img li{float: left;}
        .num{position: absolute;bottom: 20px;width: 100%;text-align: right;font-size: 0;}
        .num li{width: 15px;height: 15px;background:rgba(0,0,0,0.5);display: block;border-radius: 100%;display: inline-block;margin: 0 5px;cursor: pointer;}
        .btn{display: none;}
        .btn span{display: block;width: 50px;height: 100px;background: rgba(0,0,0,0.6);color: #fff;font-size: 40px;line-height: 100px;text-align: center;cursor:pointer;}
        .btn .prev{position: absolute;left: 0;top: 50%;margin-top: -50px;}
        .btn .next{position: absolute;right: 0;top: 50%;margin-top: -50px;}
        .num .active{background-color: #d62728;}
        .hide{display: none;}
    </style>

    <div class="page">
    <div class="banner">
        <ul class="img">
            @foreach($pdt_images as $pdt_image)
                <div>
                   <li><a ><img   width="600" height="300"   src="{{$pdt_image->image_path}}"  ></a></li>
                </div>
            @endforeach
        </ul>

        <ul class="num"></ul>
        <ul class="des" style=" background: #000; ">
            @foreach($pdt_images as $index => $pdt_image)
                <li  class="" ></li>
            @endforeach
        </ul>


    </div>
    <div class="weui_cells_title">
        <span class="bk_title">{{$product->name}}</span>
        <span class="bk_price1"  >￥ {{$product->price}}</span>
    </div>
    <div class="weui_cells">
        <div class="weui_cell">
            <p class="bk_summary">{{$product->summary}}</p>
        </div>
    </div>

    <div class="weui_cells_title">详细介绍</div>
    <div class="weui_cells">
        <div class="weui_cell">
            <p>
                {!!   $pdt_content->content !!}
            </p>
        </div>
    </div>
    </div>



<div class="bk_fix_bottom">
    <div class="bk_half_area">
        <button class="weui_btn weui_btn_primary" onclick="_addCart()">加入购物车</button>
    </div>
    <div class="bk_half_area">
        <button class="weui_btn weui_btn_default" >结算（<span id="cart_num" class="m3_price">{{$count}}</span>）</button>
    </div>
</div>
@endsection

@section('my-js')
    <script  src=""></script>

    <script>

        $(function(){

            var i=0;
            var timer=null;
            for (var j = 0; j < $('.img li').length; j++) {  //创建圆点
                $('.num').append('<li></li>')
            }
            $('.num li').first().addClass('active'); //给第一个圆点添加样式

            var firstimg=$('.img li').first().clone(); //复制第一张图片
            $('.img').append(firstimg).width($('.img li').length*($('.img img').width())); //将第一张图片放到最后一张图片后，设置ul的宽度为图片张数*图片宽度
            $('.des').width($('.img li').length*($('.img img').width()));


            // 下一个按钮
            $('.next').click(function(){
                i++;
                if (i==$('.img li').length) {
                    i=1; //这里不是i=0
                    $('.img').css({left:0}); //保证无缝轮播，设置left值
                };

                $('.img').stop().animate({left:-i*600},300);
                if (i==$('.img li').length-1) {   //设置小圆点指示
                    $('.num li').eq(0).addClass('active').siblings().removeClass('active');
                    $('.des li').eq(0).removeClass('hide').siblings().addClass('hide');
                }else{
                    $('.num li').eq(i).addClass('active').siblings().removeClass('active');
                    $('.des li').eq(i).removeClass('hide').siblings().addClass('hide');
                }

            })

            // 上一个按钮
            $('.prev').click(function(){
                i--;
                if (i==-1) {
                    i=$('.img li').length-2;
                    $('.img').css({left:-($('.img li').length-1)*600});
                }
                $('.img').stop().animate({left:-i*600},300);
                $('.num li').eq(i).addClass('active').siblings().removeClass('active');
                $('.des li').eq(i).removeClass('hide').siblings().addClass('hide');
            })

            //设置按钮的显示和隐藏
            $('.banner').hover(function(){
                $('.btn').show();
            },function(){
                $('.btn').hide();
            })

            //鼠标划入圆点
            $('.num li').mouseover(function(){
                var _index=$(this).index();
                $('.img').stop().animate({left:-_index*600},150);
                $('.num li').eq(_index).addClass('active').siblings().removeClass('active');
                $('.des li').eq(_index).removeClass('hide').siblings().addClass('hide');
            })
        })
    </script>
    <script type="text/javascript">

        function _addCart(){
            var product_id = "{{$product->id}}";
            $.ajax({
                type: "GET",
                url: '/service/cart/add/'+ product_id ,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    console.log("获取类别数据：");
                    console.log(data);
                    if (data == null) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务端错误');
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        }, 2000);
                        return;
                    }
                    if (data.status != 0) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function () {
                            $('.bk_toptips').hide();
                        }, 2000);
                        return;
                    }

                    var num = $('#cart_num').html();
                    if (num =='') num =0;
                    $('#cart_num').html(Number(num)+1);

                },

                error: function (xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            })


        }



    </script>


@endsection