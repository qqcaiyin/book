@extends('admin.master')

@section('content')
    <style>
        .clearfix:after{ content:"\20";display:block;height:0;clear:both;visibility:hidden}.clearfix{zoom:1}
        .tabBara {border-bottom: 1px solid #222 ; background-color: white; text-align: center;}
        .tabBara span {background-color:white;cursor: pointer; display: inline-block;font-weight: bold;height: 30px;line-height: 30px; padding: 0px 20px;}
        .tabBara span.current{background-color:white;color: red;}
        .tabCon {display: none}


    </style>

    <div class="cl pd-20" style=" background-color:#5bacb6">
        <img class="avatar size-XL l   round" src="{{url($member->avatar)}}"  >
        <dl style="margin-left:80px; color:#fff">
            <dt>
                <span class="f-15">{{$member->nickname}}</span>
                <span class="pl-10 f-12">余额：40</span>
            </dt>
            <dd class="pt-10 f-12" style="margin-left:0">这家伙很懒，什么也没有留下</dd>
        </dl>
    </div>

    <div id="tab_demo" class="HuiTab "  >
        <div class="tabBara clearfix  " align="center">
            <span>基本信息</span>
            <span>收件地址</span>
            <span>银行卡信息</span>
        </div>
        <div class="tabCon">
            <div class="pd-20">
                <table class="table">
                    <tbody>
                    <tr>
                        <th class="text-r" width="80">性别：</th>
                        <td>男</td>
                    </tr>
                    <tr>
                        <th class="text-r">手机：</th>
                        <td>{{$member->phone}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">邮箱：</th>
                        <td>{{$member->email}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">积分：</th>
                        <td>{{$member->point}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">等级：</th>
                        <td>VIP{{$member->vip}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">注册时间：</th>
                        <td>{{$member->register_time}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tabCon">
            <div class="pd-20">
                <table class="table">
                    <tbody>
                    <tr>
                        <th class="text-r" width="80">收件人：</th>
                        <td>{{$memberAddr->consignee}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">手机：</th>
                        <td>{{$memberAddr->moble}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">邮箱：</th>
                        <td>{{$memberAddr->email}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">地址：</th>
                        <td>{{$memberAddr->province}}
                            {{$memberAddr->city}}
                            {{$memberAddr->district}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">邮编：</th>
                        <td>{{$memberAddr->zipcode}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="tabCon">
            <div class="pd-20">
                <table class="table">
                    <tbody>
                    <tr>
                        <th class="text-r" width="80">ggg：</th>
                        <td>男</td>
                    </tr>
                    <tr>
                        <th class="text-r">手机：</th>
                        <td>{{$member->phone}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">邮箱：</th>
                        <td>{{$member->email}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">积分：</th>
                        <td>{{$member->point}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">等级：</th>
                        <td>VIP{{$member->vip}}</td>
                    </tr>
                    <tr>
                        <th class="text-r">地址：</th>
                        <td>北京市 海淀区</td>
                    </tr>
                    <tr>
                        <th class="text-r">注册时间：</th>
                        <td>{{$member->register_time}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




@endsection
@section('my-js')
<script>
    $(function(){
        $('#tab_demo').Huitab("#tab_demo .tabBara span","#tab_demo .tabCon","current","click","1")});
    // #tab_demo 父级id
    // #tab_demo .tabBar span 控制条
    // #tab_demo .tabCon 内容区
    // click 事件 点击切换，可以换成mousemove 移动鼠标切换
    // 1	默认第2个tab为当前状态（从0开始）

    !function($) {
        $.fn.Huitab = function(options){
            var defaults = {
                tabBar:'.tabBara span',
                tabCon:".tabCon",
                className:"current",
                tabEvent:"click",
                index:0,
            }
            var options = $.extend(defaults, options);
            this.each(function(){
                var that = $(this);
                that.find(options.tabBar).removeClass(options.className);
                that.find(options.tabBar).eq(options.index).addClass(options.className);
                that.find(options.tabCon).hide();
                that.find(options.tabCon).eq(options.index).show();

                that.find(options.tabBar).on(options.tabEvent,function(){
                    that.find(options.tabBar).removeClass(options.className);
                    $(this).addClass(options.className);
                    var index = that.find(options.tabBar).index(this);
                    that.find(options.tabCon).hide();
                    that.find(options.tabCon).eq(index).show();
                });
            });
        }
    } (window.jQuery);

</script>

@endsection