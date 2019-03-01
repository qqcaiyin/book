@extends('admin.master')
<style>

    .table1 tr{
        border-collapse: collapse;
        border:1px solid #e2e2e2;
    }
    .table1 ,td{
        border:0px;
    }
    .distrib-open input{
        margin-left: 20px;
    }
    .distrib-level{
        width:50%;
        margin-left: 150px;
    }
    .distrib-level th,tr,td{
        text-align: center;
        border:1px solid #007cc3;

    }
    .distrib-level th{
       padding-top: 10px;
        padding-bottom: 10px;

    }
    .distrib-level td{
        padding-top: 10px;
        padding-bottom: 10px;

    }
    .input-mi{
        border: 1px solid #ddd;
        outline:none;
        cursor: pointer;
        text-align: center;
        width:60px;
        height:25px;
        text-align:left;
        display:inline;
        border-radius:5px;
    }


</style>
@section('content')
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 营销 <span class="c-gray en">/</span> 分销 <span class="c-gray en">/</span>分销添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

<div class="page-container">
    <form  method="get" name="form1"   action="{{url('/admin/balance/log_search')}}" >
        <div class="cl pd-5  mt-20 " >
            <p  class="distrib-open" style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">分销开关：</sapn>
                <input type="radio" id="enable" name="enable" value="0"><label for="enable">不开启分销</label>
                <input type="radio" id="enable" name="enable"  checked  value="1"><label for="enable">开启一级分销</label>
                <input type="radio" id="enable" name="enable" value="2"><label for="enable">不开二级分销</label>
                <input type="radio" id="enable" name="enable"  checked  value="3"><label for="enable">开启三级分销</label>
            </p>
            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">佣金设置：</sapn>
                <table class="distrib-level">
                    <thead>
                        <tr >
                            <th width=""  style="text-align:left;" >类别</th>
                            <th width="15%">一级</th>
                            <th width="15%">二级</th>
                            <th width="15%">三级</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="c1" >
                            <td  style="text-align:left;" ><input  id="name"  type="text" class="input-mi"  style="width: 200px;"   value="分销"> </td>
                            <td><input type="text" class="input-mi"  id="level1" onchange="onlyNum(this)"   value="5">%</td>
                            <td ><input type="text" class="input-mi" id="level2" onchange="onlyNum(this)" value="3">%</td>
                            <td ><input type="text" class="input-mi" id="level3" onchange="onlyNum(this)" value="2">%</td>
                            <td><span id="del"   style=" font-size: 25px ; color: red;cursor: pointer;">x </span>     </td>
                        </tr>

                    </tbody>
                <span style=" display:inline-block; cursor: pointer; border:1px solid #ddd; width:20px; height:20px; text-align: center;line-height: 20px;">+</span><span> 添加一条</span>
                </table>
            </p>

            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd;">
                <sapn style="display: inline-block; width:150px;  text-align: right;">有效期：</sapn>

                <input  tyep="text"  id="expire" class="input-mi"  onchange="onlyNum(this)" value="2"  >&nbsp;年
                <label style="color:#bbb;">  0表示永久</label>
            </p>

            <p style="width: 100%;  padding-bottom: 5px; border-bottom: 1px dashed #ddd; ">
                <sapn style="display: inline-block; width:150px;  text-align: right;"></sapn>
                <span  id="sub"     style=" display: inline-block; height:30px; width:80px; border:1px solid #007cc3; text-align: center; vertical-align: middle;  line-height: 30px; border-radius: 4px;cursor: pointer; " >提交</span>
                <a href="{{url('/admin/info')}}"   style=" display: inline-block; height:30px; width:80px; border:1px solid #007cc3; text-align: center; vertical-align: middle;  line-height: 30px; border-radius: 4px; cursor: pointer; text-decoration: none" >返回</a>
            </p>

        </div>
    </form>
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


        //提交
        $('#sub').click(function(){

            var name = $.trim($('#name').val());
            var n =  parseInt($.trim($('#expire').val()) ) ;
               var expire = isNaN(n)? 1: n;
            var level1 =  parseInt($.trim($('#level1').val()) ) ;
            var level1 = isNaN(level1)? 1: level1;

            var level2 =  parseInt($.trim($('#level2').val()) ) ;
            var level2 = isNaN(level2)? 1: level2;

            var level3 =  parseInt($.trim($('#level3').val()) ) ;
            var level3 = isNaN(level3)? 1: level3;
            var level_type = $('input[name=enable]:checked').val();

            if(name == '' ){
                layer.msg('请填写名称', {time:2000});
                return ;
            }
            if(expire == '' ){
                layer.msg('填写有效期', {time:2000});
                return ;
            }

            $.get('/admin/service/market',{
                act:'add_distrib',
                name:name,
                level_type:level_type,
                level1:level1,
                level2:level2,
                level3:level3,
                expire:expire
            },function(res){
                if(res.status==0){
                }
                layer.msg(res.message, {time:2000});

            },'json');

        })






    </script>

@endsection