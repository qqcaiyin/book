@extends('admin.master')

@section('content')

  <div align="right" style=" margin-right: 20px;">
      关键词：<span style="color: red;">{{$keyword}} </span>
      <span> 共：{{$products->count}}条 </span>
  </div>
  <table class="table table-border table-bordered table-hover table-bg table-sort">
    <thead>
    <tr class="text-c">
      <th width="80">ID</th>
      <th width="15%">名称</th>
      <th width="40%">简介</th>
      <th width="80">价格</th>
      <th width="80">类别</th>
      <th width="120">预览图</th>
      <th width="120">操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach( $products as $product)
      <tr class="text-c">
        <th >{{$product->id}}</th>
        <th >{!! $product->name !!}</th>
        <th >{!! $product->summary !!}</th>
        <th >{{$product->price}}</th>
        <td >
          @if($product->category != null)
            {{$product->category->name}}
          @endif
        </td>
        <td>
          @if($product->preview != null)
            <img src=" {{url($product->preview)}}" style=" width:50px; height:50px;"  >
          @endif

        </td>
        <td class="f-14 td-manage">
          <a title="详情" href="javascript:;" onclick="product_info('产品详情','/admin/product_info?id={{$product->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;</i></a>
          <a style="text-decoration:none" class="ml-5"
             onClick="product_edit(
                     '>>图书详情编辑',
                     '/admin/product_edit/?id={{$product->id}}'
                     )"
             href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i>
          </a>
          <a style="text-decoration:none" class="ml-5"
             onClick="product_del('{{$product->name}}',{{$product->id}})"
             href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i>
          </a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="page_list"  align=" right" >
    {!!$products->render()!!}
  </div>
@endsection
@section('my-js')

  <script type="text/javascript">

      function product_edit(title,url) {
          layer_show(title,url,900,400);

      }

      function product_info(title,url) {
          layer_show(title,url,900,400);
      }

      function product_search(title,url,id){
          var index = layer.open({
              type: 2,
              title: title,
              content: url
          });

          layer.full(index);
      }
      /*-删除*/
      function product_del(obj,id){
          layer.confirm('确认要删除类别： '+ obj +' 吗？',function(index){
              $.ajax({
                  type: 'post',
                  url: '/admin/service/product/del', // 需要提交的 url
                  dataType: 'json',
                  data: {
                      product_id :id,
                      _token: "{{csrf_token()}}"
                  },
                  success: function(data) {
                      if(data == null) {
                          layer.msg('服务端错误', {icon:2, time:2000});
                          return;
                      }
                      if(data.status != 0) {
                          layer.msg(data.message, {icon:2, time:2000});
                          return;
                      }
                      layer.msg(data.message, {icon:1, time:2000});
                      location.replace(location.href);
                  },
                  error: function(xhr, status, error) {
                      console.log(xhr);
                      console.log(status);
                      console.log(error);
                      layer.msg('ajax error', {icon:2, time:2000});
                  },
                  // beforeSend: function(xhr){
                  //   layer.load(0, {shade: false});
                  // },
              });
          });
      }
  </script>
@endsection