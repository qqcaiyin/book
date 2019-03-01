@extends('admin.master')
<style>
    .table1 tr{
        border-collapse: collapse;
        border:1px solid #e2e2e2;
    }
    .table1 ,td{
        border:0px;
    }
    .input-mi{
        border: 0px;
        outline:none;
        cursor: pointer;
        text-align: center;
        width:200px;
        height:25px;
        text-align:left;
        display:inline;
        border-radius:5px;
    }
    .input-mi:focus{
        box-shadow: 0 0 15px  black;
    }
    .input-mi:hover{
       // background-color: red;
        border: #bbb 1px solid;
    }
</style>
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe6b6;</i>营销 <span class="c-gray en">/</span> 优惠券 <span class="c-gray en">/</span>  <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

    <div class="cl pd-5 mt-20" >
        <span class="l">
            <a class="btn btn-primary radius" href="{{url('/admin/market/quan_add')}}"  data-toggle="tooltip" data-placement="bottom" title="添加"><i class="Hui-iconfont">&#xe604;</i>添加</a>
        </span>

    </div>

    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c">
                <th width="20%"  style="text-align:left;" >券名</th>
                <th width="10%">面值</th>
                <th width="10%">数量</th>
                <th width="10%">已领取</th>
                <th width="10%">已使用</th>
                <th width="20%">有效期</th>
                <th width="5%">开启</th>
                <th width="15%">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($quanList as $v)
                <tr class="text-c">
                    <td style="text-align: left;">{{$v->name}}</td>
                    <td >{{$v->parvalue}}</td>
                    <td ><span id="issue_num{{$v->id}}">{{$v->num}}</span></td>
                    <td >{{$v->receive_num}}</td>
                    <td >{{$v->used_num}}</td>
                    <td>{{ date('Y-m-d H:i:s',$v->start_time)}}至<br>
                        {{ date('Y-m-d H:i:s',$v->end_time)}}
                    </td>
                    <td>是</td>
                    <td>
                        <a style="text-decoration:none" class="ml-5" data-id="{{$v->id}}"    title="发券" onclick="issueQuan(this)"><i class="Hui-iconfont" style="font-size: 18px;">&#xe6ca;</i>
                        </a>
                        <a style="text-decoration:none" class="ml-5" href="{{url('/admin/market/quan_issue?id=' . $v->id)}}" title="列表"><i class="Hui-iconfont">&#xe624;</i>
                        </a>
                        <a style="text-decoration:none" class="ml-5" href="{{url('/admin/market/quan_edit?id=' . $v->id)}}" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
                        </a>
                        <a style="text-decoration:none" class="ml-5" onClick="category_del('{{$v->name}}',{{$v->id}})"
                           href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe60b;</i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

    <div   class="issue-num"   style=" width:300px;  padding: 10px 30px; position: absolute;  top:20%; left: 50%; text-align: center;    border:1px solid #ddd; border-radius: 10px; display: none  ; box-shadow: 5px 5px 0 #eeeeee; background-color: #fff; ">
        <p>
            <span   style="margin-left: 10px;margin-top: 10px;">请输入生成 优惠券 的数量 </span>
            <input  type="text"  id="quan_num"   style="margin-left: 10px;margin-top: 10px; border: 1px solid #ddd; height:35px;"  onchange="onlyNum(this)"  value="0" ><br>
            <span style="display: inline-block; padding: 5px 10px ;border-radius: 3px; color:#fff ; background-color: #007cc3; margin: 10px; cursor: pointer;"  onclick="subNum(this);"    > 确认</span>
            <span style="display: inline-block; padding: 5px 10px ;border-radius: 3px; color:#000 ; background-color: #fff; margin: 10px; border:1px solid #ddd; cursor: pointer;   "  onclick="tClose();" >取消</span>
        </p>
<input type="hidden" id="issue_id"  name="issue_id"  value>
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
    function issueQuan(t) {
        $('.issue-num').show();
        var  id = $(t).data('id');
        $('#issue_id').val(id);
    }

    //

    function subNum(t){
        $('.issue-num').hide();
        var id = $('#issue_id').val();
        var num = parseInt( $.trim($('#quan_num').val()));
        $.get('/admin/service/market',{act:'issue_quan',id:id,num:num},function(res){
            if(res.status == 0){
                var n = parseInt( $.trim($('#issue_num'+id).html()));
                n=n+num;
                $('#issue_num'+id).html(n)
            }

            layer.msg(res.message, { time:3000});


        },'json');


    }
    //
    function   tClose(){
        $('.issue-num').hide();
    }
    //
    function  _change(obj,tp,id){
        var changeValue = $(obj).val();
        $.ajax({
            type: 'post',
            url: '/admin/service/category/changevalue', // 需要提交的 url
            dataType: 'json',
            data: {
                id: id,
                tp:tp,
                changeValue :changeValue,
                _token: "{{csrf_token()}}"
            },
            success: function(data) {
                console.log(data);
                if(data.status == 1|| data.status == 2){
                   var order= data.status==1? 99:0;
                    $(obj).val(order);
                    layer.msg(data.message, {icon:1, time:2000});
                    return ;
                }
                if(data.status == 3){
                    //上架
                   // $(obj).remove();
                    $(obj).parents('tr').find('.td-status').html('<span class="label label-success radius" onclick="_change(this,\''+tp+'\','+id+')">是</span>');
                    layer.msg(data.message,{icon:6,time:1000});
                    return
                }
                if(data.status == 4){
                    //下架
                   // $(obj).remove();
                    $(obj).parents('tr').find('.td-status').html('<span class="label label-defaunt radius" onclick="_change(this,\''+tp+'\','+id+')">否</span>');
                    layer.msg(data.message,{icon:5,time:1000});
                    return
                }
                if(data == null) {
                    layer.msg('服务端错误', {icon:2, time:3000});
                    return;
                }
                layer.msg(data.message, {icon:1, time:3000});
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                console.log(status);
                console.log(error);
                layer.msg('ajax error', {icon:2, time:3000});
            },
        });

    }
    /**
     * 删除分类
     *
     */
    function category_del(obj,id){
        layer.confirm('确认要删除抢购活动： '+ obj +' 吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin/service/market', // 需要提交的 url
                dataType: 'json',
                data: {
                    act:'del_skipe',
                     id :id,
                     _token: "{{csrf_token()}}"
                },
                success: function(data) {
                    console.log(data);
                    if(data == null) {
                        layer.msg('服务端错误', { time:2000});
                        return;
                    }
                    if(data.status != 0) {
                        layer.msg(data.message, { time:2000});
                        return false;
                    }
                    layer.msg(data.message, { time:2000});
                    location.replace(location.href);
                    location.replace(location.href);

                },
            });
        });
    }

</script>

@endsection