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
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe62b;</i> 会员 <span class="c-gray en">/</span> 会员管理 <span class="c-gray en">/</span>会员等级 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>

    <div class="page-container">

        <div class="cl pd-5  mt-20" >
        <span class="l">
            <a class="btn btn-primary radius" onclick="member_add('会员/会员管理/添加会员','/admin/member_add')" href="javascript:;"><i class="Hui-iconfont">&#xe604;</i> 添加会员</a>
         <a class="btn btn-primary radius" href="{{url('/admin/member')}}"><i class="Hui-iconfont">&#xe611;</i>会员列表</a>
        </span>

        </div>
        <div class="cl pd-5  mt-20" >
            <label class="">等级名称：</label>
            <input type="text" name="name"     class="input-mi"  style=" border:solid 1px #bbb;"   placeholder=" 等级" >
            <label class="">下限积分：</label>
            <input type="text" name="min_core" class="input-mi"  style=" border:solid 1px #bbb; width:100px; "   placeholder=" 0-100000" >
            <label class="">上限积分：</label>
            <input type="text" name="max_core" class="input-mi"  style=" border:solid 1px #bbb; width:100px; "   placeholder=" 0-100000" >
            <label class="">会员折扣：</label>
            <input type="text" name="discount" class="input-mi"  style=" border:solid 1px #bbb; width:100px; "   placeholder=" 1-100" >
            <a class="btn btn-primary radius" onclick="grade_add()" href="javascript:;"><i class="Hui-iconfont">&#xe6d3;</i> 新增等级</a>
        </div>

        <div class="mt-20">
            <table class="table table-border table-hover table-bg table-sort table1">
                <thead>
                <tr class="text-c">
                    <th width="" style="text-align: left;">等级名称</th>
                    <th width="100">积分下限</th>
                    <th width="100">积分上限</th>
                    <th width="100">会员折扣</th>
                    <th width="80">排序</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @if($grades != null)
                    @foreach($grades as $grade)
                        <tr class="text-c">
                            <td style="text-align: left;"><input type="text"   class="input-mi" onchange="_change(this,'name1',{{$grade->id}})"  value=" {{$grade->name}}" ></td>
                            <td><input type="text"  style=" width:80px;" class="input-mi" onchange="_change(this,'mincore1',{{$grade->id}})"  value=" {{$grade->min_core}}" ></td>
                            <td><input type="text"  style=" width:80px;" class="input-mi" onchange="_change(this,'maxcore1',{{$grade->id}})"  value=" {{$grade->max_core}}" ></td>
                            <td><input type="text"  style=" width:80px;" class="input-mi" onchange="_change(this,'discount1',{{$grade->id}})"  value=" {{$grade->discount}}" ></td>
                            <td><input type="text" style=" width:80px;"  class="input-mi" onchange="_change(this,'sort1',{{$grade->id}})"  value=" {{$grade->sort}}" ></td>
                            <td class="td-manage">
                                <a title="删除" href="javascript:;" onclick="grade_del(this,{{$grade->id}})" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    </div>

@endsection

@section('my-js')

    <script type="text/javascript">

        function member_add(title,url,id,width,height){

            var index = layer.open({
                type: 2,
                title: title,
                content: url
            });
            layer.full(index);
        }

        //添加会员等级
        function  grade_add(){
            var name = $('input[name=name]').val();
            var min_core = $('input[name=min_core]').val();
            var max_core = $('input[name=max_core]').val();
            var discount = $('input[name=discount]').val();
            $.ajax({
                type:'post',
                url:'/admin/service/member/grade_add',
                dataType: 'json',
                data:{
                    name:name,
                    min_core:min_core,
                    max_core:max_core,
                    discount:discount,
                    _token:"{{csrf_token()}}"
                },
                success:function(data){
                    if(data.status == 0){
                        //插入数据库成功
                        var  node =
                            '<tr class="text-c">'+
                            '<td style="text-align: left;"><input type="text"   class="input-mi" onchange="_change(this,\'name1\','+ data.newid+')"  value=" '+name+'" ></td>'+
                            '<td style="text-align: left;"><input type="text" style=" width:80px;"  class="input-mi" onchange="_change(this,\'mincore1\','+ data.newid+')"  value=" '+min_core+'" ></td>'+
                            '<td style="text-align: left;"><input type="text" style=" width:80px;"  class="input-mi" onchange="_change(this,\'maxcore1\','+ data.newid+')"  value=" '+max_core+'" ></td>'+
                            '<td style="text-align: left;"><input type="text" style=" width:80px;"  class="input-mi" onchange="_change(this,\'discount1\','+ data.newid+')"  value=" '+discount+'" ></td>'+
                            '<td style="text-align: left;"><input type="text" style=" width:80px;" class="input-mi" onchange="_change(this,\'sort1\','+ data.newid+')"  value=" '+0+'" ></td>'+
                            '<td class="td-manage"> <a title="删除" href="javascript:;" onclick="grade_del(this,'+data.newid+')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td> </tr>';
                        $('.table1').append(node);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    layer.msg('ajax error', {icon:2, time:3000});
                },
            });
        }

        //保存更改的值
        function  _change(obj,tp,id){
            //获得变动后的值
            var changeValue = $(obj).val();
            $.ajax({
                type: 'post',
                url: '/admin/service/member/grade', // 需要提交的 url
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
                    if(data == null) {
                        layer.msg('服务端错误', {icon:2, time:3000});
                        return;
                    }
                    layer.msg(data.message, {icon:1, time:3000});
                },
                error: function(xhr, status, error) {
                    layer.msg('ajax error', {icon:2, time:3000});
                },
            });

        }

        //删除会员等级
        function grade_del(obj,id) {
            layer.confirm('确认要删除吗？',function(index){
                $.ajax({
                    type:'post',
                   url:'/admin/service/member/grade_del',
                    dataType:'json',
                    data:{
                        id:id,
                        _token:"{{csrf_token()}}"
                    },
                    success: function(data) {
                        if(data.status == 0){
                            layer.msg('删除成功', {icon:1, time:2000});
                            //无刷新删除
                            $(obj).parent().parent().remove();
                            return ;
                        }
                        layer.msg('bug', {icon:1, time:2000});
                    },
                    error: function(xhr, status, error) {
                        layer.msg('ajax error', {icon:2, time:2000});
                    },
                });
            });
        }



    </script>

@endsection