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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe6b6;</i>营销 <span class="c-gray en">/</span> 优惠券 <span class="c-gray en">/</span>券名：[ {{$quanName}} ]<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

    <div class="cl pd-5 mt-20" >
        <span class="l">
            <a class="btn btn-primary radius" href="{{url('/admin/market/quan_list')}}"  data-toggle="tooltip" data-placement="bottom" title="返回"><i class="Hui-iconfont">&#xe6d4;</i>返回</a>
        </span>

    </div>

    <div class="mt-20">
        <table class="table table-border table-hover table-bg table-sort table1">
            <thead>
            <tr class="text-c">
                <th width="5"  ><input  type="checkbox"  id="checkall"></th>
                <th width="15%"  style="text-align:left;" >卡号</th>
                <th width="10%"  style="text-align:left;" >密码</th>
                <th width="%" style="text-align:left;">有效期</th>
                <th width="10%" >拥有着</th>
                <th width="10%">已被使用</th>
                <th width="10%">已经发放</th>
                <th width="5%"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($quanList as $v)
                <tr class="text-c">
                    <td><input  type="checkbox"></td>
                    <td style="text-align: left;">{{$v->sn}}</td>
                    <td >{{$v->pwd}}</td>
                    <td style="text-align:left;">{{ date('Y-m-d H:i:s',$v->start_time)}}至
                        {{ date('Y-m-d H:i:s',$v->end_time)}}
                    </td>
                    <td>
                        @if($v->is_recevie == 1) {{$v->nickname}}@endif
                    </td>
                    <td>
                        @if($v->is_used == 0) <span style="color: #CD4A4A"  >否   </span>
                        @elseif($v->is_used==1)<span style="color: #0BB20C;" >是   </span>
                        @endif
                    </td>
                    <td class="tt">
                        @if($v->is_issue == 0) <span style="color: #CD4A4A;cursor: pointer;"    onclick="isEnable(this,{{$v->id}})" ><i class=" ff Hui-iconfont">&#xe6a6;</i>  </span>
                        @elseif($v->is_issue==1)<span style="color: #0BB20C;cursor: pointer;"  onclick="isEnable(this,{{$v->id}})"><i class=" ff Hui-iconfont">&#xe6a7;</i>   </span>
                        @endif
                    </td>
                    <td>
                        <a style="text-decoration:none"  data-quanid="{{$v->quan_id}}"   class="ml-5" onClick="issueDetailDel(this,  {{$v->id}})"
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


    function issueDetailDel(t,id){
        var quan_id = $(t).data('quanid');
        $.get('/admin/service/market',{act:'quan_detail_del',id:id,quan_id:quan_id},function (res) {
            if(res.status==0){
                location.replace(location.href);
            }else{
                layer.msg(res.message, { time:3000});
            }
        },'json');
    }

    //
    function isEnable(t,id){

        $.get('/admin/service/market',{act:'quan_detail_issue',id:id},function (res) {
            if(res.status==0){
              if(res.data.issue == 0){
                  $(t).parents('tr').find('.tt').html('  <span style="color: #CD4A4A;cursor: pointer;"    onclick="isEnable(this,'+id+')" ><i class=" ff Hui-iconfont">&#xe6a6;</i>  </span>');
              }
              if(res.data.issue ==1){
                  $(t).parents('tr').find('.tt').html(' <span style="color: #0BB20C;cursor: pointer;"  onclick="isEnable(this,'+id+')"><i class=" ff Hui-iconfont">&#xe6a7;</i></span>');
              }

            }else{
                layer.msg(res.message, { time:3000});
            }
        },'json');
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

</script>

@endsection