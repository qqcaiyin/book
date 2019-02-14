@extends('admin.master')
<style>
 /*   .table1 tr{
        border-collapse: collapse;
        border:1px solid #e2e2e2;
    }
    .table1 ,td{
        border:0px;
    }
    .add:link{
        text-decoration:none;
    }
    label{display:inline-block;width:100px;text-align:right}
    */
</style>
@section('content')
	<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 管理员 <span class="c-gray en">/</span> 角色 <span class="c-gray en">/</span> 角色添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
	<div class="page-container">
            <form action="/admin/service/account/role/add" method="post" name="role_add" novalidate="true">
                {{csrf_field()}}
                <input type="hidden" name="" class="input-text"  >
                <table class="table  table-hover table-bg table-sort ">
                    <colgroup>
                        <col width="80px">
                        <col>
                    </colgroup>

                    <tbody>
                    <tr style="border: 0px;">
                        <th style=""> <label class="checkbox-inline">名称：</label></th>
                        <td><input type="text" class="input-text"  class="form-control" name="name" pattern="required" placeholder="请填写角色名称" required></td>
                    </tr>
                    @foreach($nodes as $node)
                        <tr>
                            <th>
                                <label class="checkbox-inline">
                                    <strong><input type="checkbox" id="checkbox_商品" onclick="checkGroupAll(this,{{$node->id}});" > {{$node->title}}</strong>
                                </label>
                            </th>
                            <td id="ul_{{$node->id}}" >
                                @foreach($node->childen as $key=> $c )
                                <div style="width:220px;float:left;">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" value="{{$c->id}}" name="node_id[]" id = "node" > [{{$node->title}}]{{$c->title}}</label>
                                </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    <tr><td></td><td>
                            <button class="btn btn-primary" type="submit">保 存</button>
                            <button class="btn btn-primary" type="button" onclick="window.location.href='/admin/account/role' ">返回</button>
                        </td></tr>
                    </tbody></table>
            </form>
	</div>
@endsection

@section('my-js')
	<script type="text/javascript">
        /**
         * 同一类的复选框，全选 和全取消
         * @return
         */
        function checkGroupAll(obj,val){
            if(obj.checked == true){
                $('#ul_'+val).find('input').prop('checked',true);
            }else{
                $('#ul_'+val).find('input').prop('checked',false);
            }
        }

	</script>
@endsection