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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 会员 <span class="c-gray en">/</span> 评论管理 <span class="c-gray en">/</span>评论列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <form  method="get" name="form1"   action="{{url('/admin/balance/log_search')}}" >
    <div class="cl pd-5  mt-20" >
        <input type="text" placeholder="完整的会员账号"  class="input-text ac_input" name="nickname" value="@if(!empty($balance_logs->ser)){{$balance_logs->ser['nickname']}}  @endif" id="search_text" style="width:150px">
        <label >日期</label>
        <input type="text" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'logmax\')||\'%y-%M-%d\'}' })" id="logmin" class="input-text Wdate"  name=" starttime"  style="width:120px;"  value="@if(!empty($balance_logs->ser)){{$balance_logs->ser['starttime']}}  @endif">
        -
        <input type="text"   name="endtime"onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'logmin\')}',maxDate:'%y-%M-%d' })" id="logmax" class="input-text Wdate" style="width:120px;"  value="@if(!empty($balance_logs->ser)){{$balance_logs->ser['endtime']}}  @endif">
        <input type="submit" class="btn btn-default" id="search_button"></input>
    </div>
    </form>
    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c">
                <th width="100" style="text-align: left;">会员 </th>
                <th width="100">订单号</th>
                <th width="100">商品名称</th>
                <th width="30%">内容</th>
                <th width="200">时间</th>
                <th width="100">显示</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            @if($comments->total()>0)
            <tbody>
                @foreach($comments as $comment)
                    <tr class="text-c">
                        <td style="text-align: left;">{{$comment->nickname}}</td>
                        <td>
                            {{$comment->order_sn}}
                        </td>
                        <td>
                            <a  target="_blank"  href="{{url('/product/'.$comment->pdt_id)}}">{{$comment->name}} </a>
                        </td>
                        <td style="padding: 5px;" >
                            <span style=" display:inline-block;   padding: 3px; border: 1px solid #ffccaa; border-radius: 3px; min-width:100%;" >
                                {{$comment->content}}
                            </span>
                        </td>
                        <td> {{date('Y-m-d h:m:s',$comment->time)}}</td>
                        <td class="td-status">
                            @if($comment->is_show == 0)
                                <span class="label label-defaunt radius" onclick="_change(this,'is_show',{{$comment->id}})">否</span>
                            @else
                                <span class="label label-success radius" onclick="_change(this,'is_show',{{$comment->id}})">是</span>
                            @endif
                        </td>
                        <td> <a style="text-decoration:none" class="ml-5"
                                onClick="_change(this,'del',{{$comment->id}})"
                                href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe60b;</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="page_list"  align=" right" >
            {!!$comments->render()!!}
        </div>
        @else
        </tbody>
        </table>
        <div align="center">
            <h3>没有相关数据<i class="Hui-iconfont">&#xe688;</i></h3>
        </div>
        @endif
    </div>

</div>




@endsection

@section('my-js')

    <script type="text/javascript">

        /**
         * tp:   is_show shi否显示
         *        del  删除
         * obj   this
         * id          类别编号
         */
        function  _change(obj,tp,id){
            $.ajax({
                type: 'post',
                url: '/admin/service/comments', // 需要提交的 url
                dataType: 'json',
                data: {
                    act:tp,
                    id: id,
                    _token: "{{csrf_token()}}"
                },
                success: function(data) {
                    if(data.status == 3){
                        //上架
                        // $(obj).remove();
                        $(obj).parents('tr').find('.td-status').html('<span class="label label-success radius" onclick="_change(this,\''+tp+'\','+id+')">是</span>');
                        layer.msg(data.message,{time:1000});
                        return
                    }
                    if(data.status == 4){
                        //下架
                        // $(obj).remove();
                        $(obj).parents('tr').find('.td-status').html('<span class="label label-defaunt radius" onclick="_change(this,\''+tp+'\','+id+')">否</span>');
                        layer.msg(data.message,{time:1000});
                        return
                    }
                    if(data == null) {
                        layer.msg('服务端错误', {time:3000});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, { time:3000});
                        return;
                    }
                    layer.msg(data.message, { time:3000});
                    // location.replace(location.href);
                     location.href= location.href;
                },
            });

        }





    </script>

@endsection