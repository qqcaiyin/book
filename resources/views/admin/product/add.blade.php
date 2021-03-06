﻿


@extends('admin.master')

<!--引入百度富文本-->
<script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/ueditor.all.min.js')}}"> </script>
<script type="text/javascript" charset="utf-8" src="{{asset('static/ueditor/lang/zh-cn/zh-cn.js')}}"></script>

<!--引入webuploader-->
<link href="/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />

<!--引入wui-date-->




@section('content')


<div class="page-container">
	<form class="form form-horizontal" id="form-product-add"  name="form-product-add"  onsubmit="article_save();"   method="post" action="{{url('/admin/service/product/add')}}" >
        {{csrf_field()}}
		<div id="tab-system" class="HuiTab">
            <div class="tabBar cl">
                <span>产品图片</span>
                <span>基本信息</span>
                <span>详情描述</span>
                <span>产品属性</span>
            </div>
<!--多图上传-->
            <div class="tabCon">
						<div class="row cl">
							<label class="form-label col-xs-4 col-sm-2">图片上传：</label>
							<div class="formControls col-xs-8 col-sm-9">
								<div class="uploader-list-container">
									<div class="queueList">
										<div id="dndArea" class="placeholder">
											<div id="filePicker-2"></div>
											<p>或将照片拖到这里，单次最多可选300张</p>
										</div>
									</div>
									<div class="statusBar" style="display:none;">
										<div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>
										<div class="info"></div>
										<div class="btns">
											<div id="filePicker2"></div>
											<div class="uploadBtn">开始上传</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id ="imagesload" ></div>
			</div>
<!--基本信息-->
            <div class="tabCon">

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						产品名称：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="name"  id="website-title" placeholder="控制在25个字、50个字节以内" value="" class="input-text">
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
						<span class="c-red">*</span>
						产品货号：</label>
					<div class="formControls col-xs-8 col-sm-9">
						<input type="text"  name="product_sn"  id="website-Keywords" placeholder="货号" value="" class="input-text" style="width:300px;">
					</div>
				</div>

				<div class="row cl">
					<label class="form-label col-xs-4 col-sm-2">
                        <span class="c-red">*</span>
						产品类别：
                    </label>
					<div class="formControls col-xs-8 col-sm-9">
					    <span class="select-box" style="width:300px;">
			                <select class="select" name="category_id" size="1" >
				                <option value="0">无</option>
							        @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
							    @endforeach
                            </select>
                        </span>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2" >
                        <span class="c-red">*</span>
                        价格：
                    </label>
                    <div class="formControls col-xs-8 col-sm-9" style="width:200px;">
                        <input type="" name="price" id="website-description" placeholder=" 价格" value="" class="input-text">
                    </div>
                    <label class="form-label col-xs-4 col-sm-2" >
                         折扣：
                    </label>
                    <div class="formControls col-xs-8 col-sm-9" style="width:150px;">
                        <input type="text" name="discount"  id="website-description" placeholder=" 折扣" value="1" class="input-text">
                    </div>
                </div>

                <div class="row cl">
                    <span class="c-red">*</span>
                    <label class="form-label col-xs-4 col-sm-2">商品库存数量：</label>
                    <div class="formControls col-xs-8 col-sm-9" style="width:200px;">
                        <input type="text"  class="input-text" value="" id="" name="num">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">上架：</label>
                    <div class="formControls col-xs-8 col-sm-9" >
                        <input name="is_show" type="checkbox" id="is_show"  value="1">
                        <label for="sex-1">选中表示上架</label>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">加入推荐：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input name="is_hot" type="checkbox" id="is_hot"  value="1">
                        <label for="is_hot">热销</label>
                        <input name="is_new" type="checkbox" id="is_new"  value="1">
                        <label for="is_new">新品</label>
                        <input name="is_best" type="checkbox" id="is_best"  value="1">
                        <label for="is_best">精品</label>
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">促销：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <input name="is_sale" type="checkbox" id="is_hot"  value="1">
                        <label for="is_sale">促销&nbsp;&nbsp;&nbsp;</label>
                        <input type="text" onfocus="WdatePicker()" id="logmin" class="input-text Wdate"  name=" start_date"  autocomplete="off"  style="width:120px;"  >
                        -
                        <input type="text"  onfocus="WdatePicker()" id="logmax" class="input-text Wdate"  name="end_date"    autocomplete="off" style="width:120px;"  >
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2" >
                        促销价：
                    </label>
                    <div class="formControls col-xs-8 col-sm-9" style="width:150px; float:left;">
                        <input type="text" name="sale_price"  id="website-description"  value="" class="input-text">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
                    <div class="formControls col-xs-8 col-sm-9" >
                        <img id="preview_id"  src="/images/jia.png" style="border: 1px solid #B8B9B9; width: 130px; height: 100px;" onclick="$('#input_id').click()" />
                        <input type="file" name="file" id="input_id" style="display: none;" onchange="return uploadImageToServer('input_id','img','images', 'preview_id');" />
                        <input type="text"  name="preview" id="img"  style="display: none;">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">商品关键词：</label>
                    <div class="formControls col-xs-8 col-sm-9" >
                        <input type="text"  name="keywords" class="input-text"  placeholder="每个关键词用逗号分隔：笔记本，15''" id="" name="">
                    </div>
                </div>

                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-2">商品简介：</label>
                    <div class="formControls col-xs-8 col-sm-9" >
                        <textarea name="summary" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" onKeyUp="$.Huitextarealength(this,100)"></textarea>
                        <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
                    </div>
                </div>

            </div>
<!--产品详情-->
            <div class="tabCon">
               <div class="row cl">
                   <label class="form-label col-xs-4 col-sm-2">产品详情：</label>
                   <div class="formControls col-xs-8 col-sm-9">
                       <textarea name="product_content" id="product_desc"  style="height: 500px;"> </textarea>

                   </div>
               </div>
            </div>
<!--规格属性-->
            <div class="tabCon">
				<div class="row cl" >
					<label class="form-label col-xs-4 col-sm-2">产品类型：</label>
					<div class="formControls col-xs-8 col-sm-9">
					<span class="select-box" style="width:200px;">
			            <select class="select" name="type_id" id="type_id" size="1" >
                            <option value="0">不分配类型</option>
                            @foreach($pdt_types as $pdt_type)
                            <option value="{{$pdt_type->id}}">{{$pdt_type->name}}</option>
                            @endforeach
                        </select>
                    </span>
                </div>
            </div>

            <div class="row cl ajaxtest" style="margin-left: 0px;">

            </div>
        </div>

        </div>
        <div class="row cl ">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button  type="submit" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
                <button  onClick="layer_close();" class="btn btn-default radius delete" type="reset">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
</form>
</div>


@endsection

@section('my-js')

	<script type="text/javascript" src="/admin/lib/webuploader/0.1.5/webuploader.min.js"></script>
	<!--请在下方写此页面业务相关的脚本-->

    <script type="text/javascript">
        //实例化百度编辑器
        var ue = UE.getEditor('product_desc');


        $('#type_id').on('change',function(){
            var type_id =  $('select[name=type_id] option:selected').val();
            _ajaxTestShow(type_id);
        });


        function _ajaxTestShow(id){
            $.get(
                "{{ url('/admin/product_add/attributes')}}",
                {  'id':id ,  '_token': "{{csrf_token()}}"},
                function (html) {
                    $('.ajaxtest').empty();
                    $('.ajaxtest').append( html );
                });
        }
        $(function(){
            $('.skin-minimal input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });
            $("#tab-system").Huitab({
                index:0
            });
        });

    </script>


	<script type="text/javascript">
        function article_save(){
            window.parent.location.reload();
        }

        $(function(){
            $('.uploadBtn input').iCheck({
                checkboxClass: 'icheckbox-blue',
                radioClass: 'iradio-blue',
                increaseArea: '20%'
            });

            $list = $("#fileList"),
                $btn = $("#btn-star"),
                state = "pending",
                uploader;

            var uploader = WebUploader.create({
                auto: true,
                swf: '/admin/lib/webuploader/0.1.5/Uploader.swf',

                // 文件接收服务端。
                server: '/service/uploadimg',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });
            uploader.on( 'fileQueued', function( file ) {
                var $li = $(
                    '<div id="' + file.id + '" class="item">' +
                    '<div class="pic-box"><img></div>'+
                    '<div class="info">' + file.name + '</div>' +
                    '<p class="state">等待上传...</p>'+
                    '</div>'
                    ),
                    $img = $li.find('img');
                $list.append( $li );

                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb( file, function( error, src ) {
                    if ( error ) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr( 'src', src );
                }, thumbnailWidth, thumbnailHeight );
            });
            // 文件上传过程中创建进度条实时显示。
            uploader.on( 'uploadProgress', function( file, percentage ) {
                var $li = $( '#'+file.id ),
                    $percent = $li.find('.progress-box .sr-only');

                // 避免重复创建
                if ( !$percent.length ) {
                    $percent = $('<div class="progress-box"><span class="progress-bar radius"><span class="sr-only" style="width:0%"></span></span></div>').appendTo( $li ).find('.sr-only');
                }
                $li.find(".state").text("上传中");
                $percent.css( 'width', percentage * 100 + '%' );
            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on( 'uploadSuccess', function( file ) {
                alert('bbb');
                $( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
            });

            // 文件上传失败，显示上传出错。
            uploader.on( 'uploadError', function( file ) {
                $( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
            });

            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).find('.progress-box').fadeOut();
            });
            uploader.on('all', function (type) {
                if (type === 'startUpload') {
                    state = 'uploading';
                } else if (type === 'stopUpload') {
                    state = 'paused';
                } else if (type === 'uploadFinished') {
                    state = 'done';
                }

                if (state === 'uploading') {
                    $btn.text('暂停上传');
                } else {
                    $btn.text('开始上传');
                }
            });

            $btn.on('click', function () {
                if (state === 'uploading') {
                    uploader.stop();
                } else {
                    uploader.upload();
                }
            });

        });

        (function( $ ){
            // 当domReady的时候开始初始化
            $(function() {
                var $wrap = $('.uploader-list-container'),

                    // 图片容器
                    $queue = $( '<ul class="filelist"></ul>' )
                        .appendTo( $wrap.find( '.queueList' ) ),

                    // 状态栏，包括进度和控制按钮
                    $statusBar = $wrap.find( '.statusBar' ),

                    // 文件总体选择信息。
                    $info = $statusBar.find( '.info' ),

                    // 上传按钮
                    $upload = $wrap.find( '.uploadBtn' ),

                    // 没选择文件之前的内容。
                    $placeHolder = $wrap.find( '.placeholder' ),

                    $progress = $statusBar.find( '.progress' ).hide(),

                    // 添加的文件数量
                    fileCount = 0,

                    // 添加的文件总大小
                    fileSize = 0,

                    // 优化retina, 在retina下这个值是2
                    ratio = window.devicePixelRatio || 1,

                    // 缩略图大小
                    thumbnailWidth = 110 * ratio,
                    thumbnailHeight = 110 * ratio,

                    // 可能有pedding, ready, uploading, confirm, done.
                    state = 'pedding',

                    // 所有文件的进度信息，key为file id
                    percentages = {},
                    // 判断浏览器是否支持图片的base64
                    isSupportBase64 = ( function() {
                        var data = new Image();
                        var support = true;
                        data.onload = data.onerror = function() {
                            if( this.width != 1 || this.height != 1 ) {
                                support = false;
                            }
                        }
                        data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                        return support;
                    } )(),

                    // 检测是否已经安装flash，检测flash的版本
                    flashVersion = ( function() {
                        var version;

                        try {
                            version = navigator.plugins[ 'Shockwave Flash' ];
                            version = version.description;
                        } catch ( ex ) {
                            try {
                                version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                                    .GetVariable('$version');
                            } catch ( ex2 ) {
                                version = '0.0';
                            }
                        }
                        version = version.match( /\d+/g );
                        return parseFloat( version[ 0 ] + '.' + version[ 1 ], 10 );
                    } )(),

                    supportTransition = (function(){
                        var s = document.createElement('p').style,
                            r = 'transition' in s ||
                                'WebkitTransition' in s ||
                                'MozTransition' in s ||
                                'msTransition' in s ||
                                'OTransition' in s;
                        s = null;
                        return r;
                    })(),

                    // WebUploader实例
                    uploader;

                if ( !WebUploader.Uploader.support('flash') && WebUploader.browser.ie ) {

                    // flash 安装了但是版本过低。
                    if (flashVersion) {
                        (function(container) {
                            window['expressinstallcallback'] = function( state ) {
                                switch(state) {
                                    case 'Download.Cancelled':
                                        alert('您取消了更新！')
                                        break;

                                    case 'Download.Failed':
                                        alert('安装失败')
                                        break;

                                    default:
                                        alert('安装已成功，请刷新！');
                                        break;
                                }
                                delete window['expressinstallcallback'];
                            };

                            var swf = 'expressInstall.swf';
                            // insert flash object
                            var html = '<object type="application/' +
                                'x-shockwave-flash" data="' +  swf + '" ';

                            if (WebUploader.browser.ie) {
                                html += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                            }

                            html += 'width="100%" height="100%" style="outline:0">'  +
                                '<param name="movie" value="' + swf + '" />' +
                                '<param name="wmode" value="transparent" />' +
                                '<param name="allowscriptaccess" value="always" />' +
                                '</object>';

                            container.html(html);

                        })($wrap);

                        // 压根就没有安转。
                    } else {
                        $wrap.html('<a href="http://www.adobe.com/go/getflashplayer" target="_blank" border="0"><img alt="get flash player" src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" /></a>');
                    }
                    return;
                } else if (!WebUploader.Uploader.support()) {
                    alert( 'Web Uploader 不支持您的浏览器！');
                    return;
                }

                // 实例化
                uploader = WebUploader.create({
                    pick: {
                        id: '#filePicker-2',
                        label: '点击选择图片'
                    },
                    formData: {
                        uid: 123
                    },
                    dnd: '#dndArea',
                    paste: '#uploader',
                    swf: '/admin/lib/webuploader/0.1.5/Uploader.swf',
                    chunked: false,
                    chunkSize: 512 * 1024,
                    server: '/service/uploadimg',
                    // runtimeOrder: 'flash',

                    // accept: {
                    //     title: 'Images',
                    //     extensions: 'gif,jpg,jpeg,bmp,png',
                    //     mimeTypes: 'image/*'
                    // },

                    // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
                    disableGlobalDnd: true,
                    fileNumLimit: 300,
                    fileSizeLimit: 200 * 1024 * 1024,    // 200 M
                    fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M
                });

                uploader.on( 'uploadSuccess', function( file ,response) {
//*****上传成功后，路径保存到隐藏域
                    var url = response.src;
                    //便于表单提交数据
                    var input ='<input name="imgs[]"   id="images'+file.id+'" type="hidden" value="'+url+'">';
                    $('#imagesload').append( input );

                    $btns = $('<div class="file-panel">' +
                        '<span class="cancel">删除</span>' +
                        '' +
                        '</div>').appendTo( '#file.'+file.id );

                    $( '#'+file.id ).addClass('upload-state-success').find(".state").text("已上传");
                });



                // 拖拽时不接受 js, txt 文件。
                uploader.on( 'dndAccept', function( items ) {
                    var denied = false,
                        len = items.length,
                        i = 0,
                        // 修改js类型
                        unAllowed = 'text/plain;application/javascript ';

                    for ( ; i < len; i++ ) {
                        // 如果在列表里面
                        if ( ~unAllowed.indexOf( items[ i ].type ) ) {
                            denied = true;
                            break;
                        }
                    }

                    return !denied;
                });

                uploader.on('dialogOpen', function() {
                    console.log('here');
                });

                // uploader.on('filesQueued', function() {
                //     uploader.sort(function( a, b ) {
                //         if ( a.name < b.name )
                //           return -1;
                //         if ( a.name > b.name )
                //           return 1;
                //         return 0;
                //     });
                // });

                // 添加“添加文件”的按钮，
                uploader.addButton({
                    id: '#filePicker2',
                    label: '继续添加'
                });

                uploader.on('ready', function() {
                    window.uploader = uploader;
                });

                // 当有文件添加进来时执行，负责view的创建
                function addFile( file ) {
                    var $li = $( '<li id="' + file.id + '">' +
                        '<p class="title">' + file.name + '</p>' +
                        '<p class="imgWrap"></p>'+
                        '<p class="progress"><span></span></p>' +
                        '</li>' ),

                        $btns = $('<div class="file-panel">' +
                            '<span class="cancel">删除</span>' +
                            '<span class="rotateRight">向右旋转</span>' +
                            '<span class="rotateLeft">向左旋转</span></div>').appendTo( $li ),
                        $prgress = $li.find('p.progress span'),
                        $wrap = $li.find( 'p.imgWrap' ),
                        $info = $('<p class="error"></p>'),

                        showError = function( code ) {
                            switch( code ) {
                                case 'exceed_size':
                                    text = '文件大小超出';
                                    break;

                                case 'interrupt':
                                    text = '上传暂停';
                                    break;

                                default:
                                    text = '上传失败，请重试';
                                    break;
                            }

                            $info.text( text ).appendTo( $li );
                        };

                    if ( file.getStatus() === 'invalid' ) {
                        showError( file.statusText );
                    } else {
                        // @todo lazyload
                        $wrap.text( '预览中' );
                        uploader.makeThumb( file, function( error, src ) {
                            var img;

                            if ( error ) {
                                $wrap.text( '不能预览' );
                                return;
                            }

                            if( isSupportBase64 ) {
                                img = $('<img src="'+src+'">');
                                $wrap.empty().append( img );
                            } else {
                                $.ajax('lib/webuploader/0.1.5/server/preview.php', {
                                    method: 'POST',
                                    data: src,
                                    dataType:'json'
                                }).done(function( response ) {
                                    if (response.result) {
                                        img = $('<img src="'+response.result+'">');
                                        $wrap.empty().append( img );
                                    } else {
                                        $wrap.text("预览出错");
                                    }
                                });
                            }
                        }, thumbnailWidth, thumbnailHeight );

                        percentages[ file.id ] = [ file.size, 0 ];
                        file.rotation = 0;
                    }

                    file.on('statuschange', function( cur, prev ) {
                        if ( prev === 'progress' ) {
                            $prgress.hide().width(0);
                        } else if ( prev === 'queued' ) {
                        //   $li.off( 'mouseenter mouseleave' );
                          //$btns.remove();
//上传成功后，仍然后删除图标
                            $li.find('.rotateRight').remove();
                            $li.find('.rotateLeft').remove();

                        }

                        // 成功
                        if ( cur === 'error' || cur === 'invalid' ) {
                            console.log( file.statusText );
                            showError( file.statusText );
                            percentages[ file.id ][ 1 ] = 1;
                        } else if ( cur === 'interrupt' ) {
                            showError( 'interrupt' );
                        } else if ( cur === 'queued' ) {
                            percentages[ file.id ][ 1 ] = 0;
                        } else if ( cur === 'progress' ) {
                            $info.remove();
                            $prgress.css('display', 'block');
                        } else if ( cur === 'complete' ) {
                            $li.append( '<span class="success"></span>' );
                        }
                        $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
                    });

                    $li.on( 'mouseenter', function() {
                        $btns.stop().animate({height: 30});
                    });

                    $li.on( 'mouseleave', function() {
                        $btns.stop().animate({height: 0});
                    });

                    $btns.on( 'click', 'span', function() {
                        var index = $(this).index(),
                            deg;

                        switch ( index ) {
                            case 0:
                                uploader.removeFile( file );
                                return;

                            case 1:
                                file.rotation += 90;
                                break;

                            case 2:
                                file.rotation -= 90;
                                break;
                        }

                        if ( supportTransition ) {
                            deg = 'rotate(' + file.rotation + 'deg)';
                            $wrap.css({
                                '-webkit-transform': deg,
                                '-mos-transform': deg,
                                '-o-transform': deg,
                                'transform': deg
                            });
                        } else {
                            $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');

                        }


                    });

                    $li.appendTo( $queue );
                }
//调试删除
                // 负责view的销毁
                function removeFile( file ) {
                    var $li = $('#'+file.id);
                    delete percentages[ file.id ];
                    updateTotalProgress();
                    $li.off().find('.file-panel').off().end().remove();
//删除已上传的图片
                    var $imgId = $('#images'+file.id);
                    var imgIdSrc = $imgId.val();
//删除图片后，把对应的<input> 标签移除，防止表单提交给后台
                    $imgId.remove();
                    $.get('/service/product/imgs_del',{'src':imgIdSrc},function(data){
                        if(data.status == 0){
                            alert('删除成功');
                        }
                    },'json');

                }

                function updateTotalProgress() {
                    var loaded = 0,
                        total = 0,
                        spans = $progress.children(),
                        percent;

                    $.each( percentages, function( k, v ) {
                        total += v[ 0 ];
                        loaded += v[ 0 ] * v[ 1 ];
                    } );

                    percent = total ? loaded / total : 0;


                    spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
                    spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
                    updateStatus();
                }

                function updateStatus() {
                    var text = '', stats;

                    if ( state === 'ready' ) {
                        text = '选中' + fileCount + '张图片，共' +
                            WebUploader.formatSize( fileSize ) + '。';
                    } else if ( state === 'confirm' ) {
                        stats = uploader.getStats();
                        if ( stats.uploadFailNum ) {
                            text = '已成功上传' + stats.successNum+ '张照片至XX相册，'+
                                stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
                        }

                    } else {
                        stats = uploader.getStats();
                        text = '共' + fileCount + '张（' +
                            WebUploader.formatSize( fileSize )  +
                            '），已上传' + stats.successNum + '张';

                        if ( stats.uploadFailNum ) {
                            text += '，失败' + stats.uploadFailNum + '张';
                        }
                    }

                    $info.html( text );
                }

                function setState( val ) {
                    var file, stats;

                    if ( val === state ) {
                        return;
                    }

                    $upload.removeClass( 'state-' + state );
                    $upload.addClass( 'state-' + val );
                    state = val;

                    switch ( state ) {
                        case 'pedding':
                            $placeHolder.removeClass( 'element-invisible' );
                            $queue.hide();
                            $statusBar.addClass( 'element-invisible' );
                            uploader.refresh();
                            break;

                        case 'ready':
                            $placeHolder.addClass( 'element-invisible' );
                            $( '#filePicker2' ).removeClass( 'element-invisible');
                            $queue.show();
                            $statusBar.removeClass('element-invisible');
                            uploader.refresh();
                            break;

                        case 'uploading':
                            $( '#filePicker2' ).addClass( 'element-invisible' );
                            $progress.show();
                            $upload.text( '暂停上传' );
                            break;

                        case 'paused':
                            $progress.show();
                            $upload.text( '继续上传' );
                            break;

                        case 'confirm':
                            $progress.hide();
                            $( '#filePicker2' ).removeClass( 'element-invisible' );
                            $upload.text( '开始上传' );

                            stats = uploader.getStats();
                            if ( stats.successNum && !stats.uploadFailNum ) {
                                setState( 'finish' );
                                return;
                            }
                            break;
                        case 'finish':
                            stats = uploader.getStats();
                            if ( stats.successNum ) {
                                alert( '上传成功' );
                            } else {
                                // 没有成功的图片，重设
                                state = 'done';
                                location.reload();
                            }
                            break;
                    }

                    updateStatus();
                }

                uploader.onUploadProgress = function( file, percentage ) {
                    var $li = $('#'+file.id),
                        $percent = $li.find('.progress span');

                    $percent.css( 'width', percentage * 100 + '%' );
                    percentages[ file.id ][ 1 ] = percentage;
                    updateTotalProgress();
                };

                uploader.onFileQueued = function( file ) {
                    fileCount++;
                    fileSize += file.size;

                    if ( fileCount === 1 ) {
                        $placeHolder.addClass( 'element-invisible' );
                        $statusBar.show();
                    }

                    addFile( file );
                    setState( 'ready' );
                    updateTotalProgress();
                };

                uploader.onFileDequeued = function( file ) {
                    fileCount--;
                    fileSize -= file.size;

                    if ( !fileCount ) {
                        setState( 'pedding' );
                    }

                    removeFile( file );
                    updateTotalProgress();

                };

                uploader.on( 'all', function( type ) {
                    var stats;
                    switch( type ) {
                        case 'uploadFinished':
                            setState( 'confirm' );
                            break;

                        case 'startUpload':
                            setState( 'uploading' );
                            break;

                        case 'stopUpload':
                            setState( 'paused' );
                            break;

                    }
                });

                uploader.onError = function( code ) {
                    alert( 'Eroor: ' + code );
                };

                $upload.on('click', function() {
                    if ( $(this).hasClass( 'disabled' ) ) {
                        return false;
                    }
                    if ( state === 'ready' ) {


                        uploader.upload();
                    } else if ( state === 'paused' ) {
                        uploader.upload();
                    } else if ( state === 'uploading' ) {
                        uploader.stop();
                    }
                });

                $info.on( 'click', '.retry', function() {
                    uploader.retry();
                } );

                $info.on( 'click', '.ignore', function() {
                    alert( 'todo' );
                } );

                $upload.addClass( 'state-' + state );
                updateTotalProgress();
            });

        })( jQuery );
	</script>

@endsection
