@extends('admin.master')

@section('content')

<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/index">小米商城</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/aboutHui.shtml">控制台</a>
            <span class="logo navbar-slogan f-l mr-10 hidden-xs">后台管理</span>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>{{$username}}</li>
                    <li><a href="{{url('/admin/out')}}">退出</a></li>
                    <li id="Hui-msg"> <a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <dl id="menu-product">
            <dt><i class="Hui-iconfont">&#xe620;</i> 产品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    @if(  in_array('toProductList' ,(Session::get('admin_info'))[1] ) || (!Session::get('rbac_open')) )
                    <li><a data-href="{{url('/admin/product')}}" data-title="产品列表" href="javascript:void(0)">产品列表</a></li>
                    @endif
                    @if(  in_array('toCategoryList' ,(Session::get('admin_info'))[1] ) || (!Session::get('rbac_open')))
                        <li><a data-href="{{url('/admin/category/')}}" data-title="产品分类" href="javascript:void(0)">产品分类</a></li>
                    @endif
                     @if(  in_array('toProductList' ,(Session::get('admin_info'))[1] ) || (!Session::get('rbac_open')))
                    <li><a data-href="{{url('/admin/type')}}" data-title="产品类型" href="javascript:void(0)">产品类型</a></li>
                    @endif
                </ul>
            </dd>
        </dl>

        <dl id="menu-tongji">
            <dt><i class="Hui-iconfont">&#xe61a;</i> 订单管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{url('/admin/order')}}" data-title="订单列表" href="javascript:void(0)">订单列表</a></li>
                    <li><a data-href="{{url('/admin/return_list')}}" data-title="退货管理" href="javascript:void(0)">退货管理</a></li>
                </ul>
            </dd>
        </dl>

        <dl id="menu-member">
            <dt><i class="Hui-iconfont">&#xe60d;</i> 会员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{url('/admin/member')}}" data-title="会员列表" href="javascript:;">会员列表</a></li>
                    <li><a data-href="{{url('/admin/grade')}}" data-title="等级管理" href="javascript:;">等级管理</a></li>
                    <li><a data-href="{{url('/admin/balance')}}" data-title="余额管理" href="javascript:;">余额管理</a></li>
                    <li><a data-href="member-record-browse.html" data-title="提现管理" href="javascript:void(0)">提现管理</a></li>
                    <li><a data-href="{{url('/admin/comments')}}" data-title="评论列表" href="javascript:;">评论列表</a></li>
                </ul>
            </dd>
        </dl>

        <dl id="menu-comments">
            <dt><i class="Hui-iconfont">&#xe622;</i> 营销管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{url('/admin/market/skipe')}}" data-title="限时抢购" href="javascript:;">限时抢购</a></li>
                    <li><a data-href="{{url('/admin/comments')}}" data-title="拼团" href="javascript:;">拼团</a></li>
                    <li><a data-href="{{url('/admin/market/quan_list')}}" data-title="优惠券" href="javascript:;">优惠券</a></li>
                    <li><a data-href="{{url('/admin/market/distrib_add')}}" data-title="分销" href="javascript:;">分销</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">
            <dt><i class="Hui-iconfont">&#xe62d;</i> 管理员管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{url('/admin/account/admin')}}" data-title="管理员列表" href="javascript:void(0)">管理员列表</a></li>
                    <li><a data-href="{{url('/admin/account/role')}}" data-title="角色管理" href="javascript:void(0)">角色管理</a></li>
                </ul>
            </dd>
        </dl>

        <dl id="menu-tongji">
            <dt><i class="Hui-iconfont">&#xe61a;</i> 系统统计<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{url('/admin/charts/sale_total')}}" data-title="销售统计" href="javascript:void(0)">销售统计</a></li>
                </ul>
            </dd>
        </dl>

        <dl id="menu-system">
            <dt><i class="Hui-iconfont">&#xe62e;</i> 系统管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="system-base.html" data-title="系统设置" href="javascript:void(0)">系统设置</a></li>
                    <li><a data-href="system-category.html" data-title="栏目管理" href="javascript:void(0)">栏目管理</a></li>
                    <li><a data-href="/admin/sys/ship" data-title="配送方式" href="javascript:void(0)">配送方式</a></li>
                    <li><a data-href="system-data.html" data-title="数据字典" href="javascript:void(0)">数据字典</a></li>
                    <li><a data-href="{{url('/admin/shield')}}" data-title="屏蔽词" href="javascript:void(0)">屏蔽词</a></li>
                    <li><a data-href="system-log.html" data-title="系统日志" href="javascript:void(0)">系统日志</a></li>
                </ul>
            </dd>
        </dl>


    </div>
</aside>

    <section class="Hui-article-box">
        <div id="Hui-tabNav" class="Hui-tabNav hidden-xs" >
            <div class="Hui-tabNav-wp">
                <ul id="min_title_list" class="acrossTab cl" >

                </ul>
            </div>
            <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
        </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="/admin/info"></iframe>
        </div>
    </div>
</section>

<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前 </li>
        <li id="closeall">关闭全部 </li>
    </ul>
</div>
@endsection