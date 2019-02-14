

@extends('admin.master')

@section('content')

<style>
  .table{
      width:100%;
      max-width:100%;
      margin-bottom: 20px;
  }
    table{
        border-spacing: 0;
        border-collapse: collapse;

    }

     td{

        border-bottom:1px solid #ddd;
    }


</style>



<div class="container">
    <table class="table ">
        <tr>
            <td class="text-center"><h3>{if:isset($set['name'])}{$set['name']}{/if}购物清单</h3></td>
        </tr>
        <tr>
            <td>客户：{$accept_name}，地址：{$address}，电话：{$mobile}</td>
        </tr>
    </table>

    <table class="table table-condensed">
        <colgroup>
            <col width="50%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
        </colgroup>

        <tbody>
        <tr>
            <th colspan="2">
                <b>订单号：{$order_no}</b>
            </th>
            <th colspan="4" class="text-right">
                <b>订购日期：{echo:date('Y-m-d',strtotime($create_time))}</b>
            </th>
        </tr>

        <tr>
            <th>商品名称</th>
            <th>商品货号</th>
            <th>单价</th>
            <th>重量</th>
            <th>数量</th>
            <th>小计</th>
        </tr>
        {foreach:items=Api::run('getOrderGoodsRowByOrderId',array('id'=>$id))}
        {set:$goodsRow = JSON::decode($item['goods_array'])}
        <tr>
            <td>
                {$goodsRow['name']}
                <p>{$goodsRow['value']}</p>
                {foreach:items=Api::run('getBrandByGoodsId',array('id'=>$item["goods_id"])) item=$brandRow}
                【{$brandRow['name']}】
                {/foreach}
            </td>
            <td>{$goodsRow['goodsno']}</td>
            <td>￥{$item['goods_price']}</td>
            <td>{echo:common::formatWeight($item['goods_weight'])}</td>
            <td>{$item['goods_nums']}</td>
            <td>￥{echo:$item['goods_price'] * $item['goods_nums']}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>

    <table class="table table-condensed text-right">
        <tr>
            <td>商品总价：￥{$payable_amount}</td>
        </tr>
        <tr>
            <td>订单优惠：￥{echo:$promotions+$discount}</td>
        </tr>
        <tr>
            <td>运费价格：￥{$real_freight}</td>
        </tr>
        <tr>
            <td>订单价格：￥{$order_amount}</td>
        </tr>
        <tr>
            <td align="left">订单附言：{$postscript}</td>
        </tr>
    </table>

    <table class="table table-condensed">
        <colgroup>
            <col />
            <col width="350px" />
        </colgroup>

        <tr>
            <td>服务商：{if:isset($set['name'])}{$set['name']}{/if}</td>
            <td>电话：{if:isset($set['phone'])}{$set['phone']}{/if}</td>
        </tr>
        <tr>
            <td>邮箱：{if:isset($set['email'])}{$set['email']}{/if}</td>
            <td>网站：{if:isset($set['url'])}{$set['url']}{/if}</td>
        </tr>
    </table>

    <input type="submit" class="btn btn-success btn-lg btn-block hidden-print" onclick="window.print();" value="打印" />
</div>

<div class="container">
    <table class="table table-condensed">
        <colgroup>
            <col width="40%" />
            <col width="20%" />
            <col width="40%" />
        </colgroup>
        <tr>
            <td>
                <p>订单号:{$order_no}</p>
                <p>日期:{echo:date('Y-m-d',strtotime($create_time))}</p>
            </td>
            <td class="text-center"><h4>{if:isset($set['name'])}{$set['name']}{/if}配货清单</h4></td>
            <td class="text-right">
                <p>客户:{$accept_name}</p>
                <p>电话:{$mobile}</p>
            </td>
        </tr>
    </table>

    <table class="table table-condensed">
        <colgroup>
            <col width="60%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
            <col width="10%" />
        </colgroup>

        <tbody>
        <tr>
            <th>商品名称</th>
            <th>商品货号</th>
            <th>单价</th>
            <th>数量</th>
            <th>小计</th>
        </tr>
        {foreach:items=Api::run('getOrderGoodsRowIsSendByOrderId',array('id'=>$id))}
        {set:$goodsRow = JSON::decode($item['goods_array'])}
        <tr>
            <td>
                {$goodsRow['name']}
                <p>{$goodsRow['value']}</p>
                {foreach:items=Api::run('getBrandByGoodsId',array('id'=>$item["goods_id"])) item=$brandRow}
                【{$brandRow['name']}】
                {/foreach}
            </td>
            <td>{$goodsRow['goodsno']}</td>
            <td>￥{$item['goods_price']}</td>
            <td>{$item['goods_nums']}</td>
            <td>￥{echo:$item['goods_price'] * $item['goods_nums']}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>

    <table class="table table-condensed">
        <colgroup>
            <col width="50%" />
            <col width="50%" />
        </colgroup>

        <tr>
            <td>订单附言：{$postscript}</td>
            <td>配送：{foreach:items=Api::run('getDeliveryById',array('distribution'=>$distribution))}{$item['name']}{/foreach}</td>
        </tr>
        <tr>
            <td>地址：{$address}</td>
            <td>收货人：{$accept_name}</td>
        </tr>
        <tr>
            <td>手机：{$mobile}</td>
            <td>电话：{$telphone}</td>
        </tr>
        <tr>
            <td colspan="2">订单备注：{$note}</td>
        </tr>
    </table>

    <table class="table table-condensed">
        <tr><td><h4><strong>签字：</strong></h4></td></tr>
    </table>

    <input type="submit" class="btn btn-success btn-block btn-lg hidden-print" onclick="window.print();" value="打印" />
</div>


@endsection

@section('my-js')


@endsection