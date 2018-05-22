$(function () {

    /**
     * 上传组件的配置信息
     * @param api {server:'请求地址', gallery_url:'图库地址'}
     * @returns {*}
     */
    $.webuploaderConfig = function(api){


        $.webuploader_for_amazeui = function (param) {
            //具体参数请参考http://fex.baidu.com/webuploader/doc/index.html
            var obj = {
                //上传表单的名称，默认为file
                fileVal: 'upfile',
                // 自动上传。默认为开启 true | false
                auto: true,
                //是否允许重复上传，禁止则当前文件只可以上传一次。需要刷新才可以再次上场 默认为开启 true | false
                duplicate: true,
                // 文件接收服务端。
                server: api.server,
                // swf文件路径
                swf: 'Uploader.swf',
                //是否打开图库 默认为 关闭false | true开启
                gallery: false,

                thumb:{type:''}
            };


            $.extend(obj, param);

            // 优化retina, 在retina下这个值是2
            var ratio = window.devicePixelRatio || 1,
            // 缩略图大小
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,
            // Web Uploader实例
                uploader;

            // 初始化Web Uploader
            uploader = WebUploader.create(obj);

            $('.am-btn').on('click', function () {
                uploader.upload();
            });

            // 当有文件添加进来的时候
            uploader.on('fileQueued', function (file) {

                // 创建缩略图
                uploader.makeThumb(file, function (error, src) {

                    //没有缩略图则选用预设的图案
                    if (error) {
                        var $li =
                            '<div class="am-gallery-item webuploader-item am-img-thumbnail">' +
                            '<a href="javascript:;" class="file-preview-other" >' +
                            '<i class="am-icon-file-o am-icon-lg am-block"></i>' +
                            '<h3 class="am-gallery-title am-text-center am-hide"></h3>' +
                            '</a>' +
                            '<div class="am-text-truncate am-text-xs file-preview-other-text am-text-center" >' + file.name + '</div> ' +
                            '</div>';
                    } else {
                        var $li =
                            '<div class="am-gallery-item webuploader-item am-img-thumbnail">' +
                            '<a href="javascript:;" >' +
                            '<img src="' + src + '"  alt="点击上传图片"/>' +
                            '<h3 class="am-gallery-title am-text-center am-hide"></h3>' +
                            '</a>' +
                            '</div>'
                    }

                    var appendStr = '<li id="' + file.id + '">' + $li + '</li>';

                    if (obj.pick.multiple == true) {
                        $("#before" + obj.id).before(appendStr);
                    } else {
                        $("#before" + obj.id).prevAll().remove();
                        $("#before" + obj.id).before(appendStr);
                    }

                }, thumbnailWidth, thumbnailHeight);
            });

            //进度条直接使用妹子UI的
            uploader.on('uploadProgress', function (file, percentage) {
                $.AMUI.progress.start(percentage);
            });

            // 文件上传成功
            uploader.on('uploadSuccess', function (file, response) {
                //上传成功，则在对应文件的li层追加一个隐藏域存放上传成功的图片URL
                if (response.state == 'SUCCESS') {
                    $('#' + file.id).append('<input type="hidden" name="' + obj.name + '" value="' + response.url + '">');
                }
                $('#' + file.id + ' h3.am-gallery-title').html(response.state).removeClass('am-hide');
            });

            // 文件上传失败
            uploader.on('uploadError', function (file, reason) {
                $('#' + file.id + ' h3.am-gallery-title').html('上传失败').removeClass('am-hide');
            });

            // 完成上传完了，成功或者失败，结束进度条。
            uploader.on('uploadComplete', function (file) {
                $.AMUI.progress.done();
            });
        };

        /**
         * 声明简易版的上传组件
         */
        $('[data-am-webuploader-simple]').each(function () {
            var options = AMUIwebuploader.options($(this).attr('data-am-webuploader-simple'));
            //初始化简易版的上传样式
            $(this).html(AMUIwebuploader.template(options.id, options.type, options.pick.multiple, options.gallery));

            //输出预设内容
            // @todo还要修改遍历方法
            if (options.content) {
                var inputName = options.content.split(',').length == 1 ? options.name : options.name + '[]';

                $("#before" + options.id).prevAll().remove();
                $.each(options.content.split(','), function (key, value) {
                    AMUIwebuploader.append({
                        id:options.id,
                        src:value,
                        name:inputName
                    });
                });
            }
            $.webuploader_for_amazeui(options);
        });

        /**
         * 依次为 初始化弹窗的对象 、 图库的选项
         * @type {{}}
         */
        var gallery_dialog = {}, gallery_option = {};

        /**
         * 弹出图库选择框
         */
        $(document).on('click', '.commonly', function () {
            //读取必要的配置信息
            gallery_option = {
                id:$(this).attr('data'),
                name:$(this).attr('data'),
                multiple: $(this).attr('data-multiple') == 'true' ? true : false
            };

            gallery_dialog = dialog({
                id: 'commonly-gallery',
                title: '打开图库'
            });

            //加载请求
            $.get(api.gallery_url, function (data) {
                gallery_dialog.content('<div id="commonly-gallery-content">' + data + '</div>');
                gallery_dialog.show();
            })

        });

        /**
         * 切换上下页
         */
        $(document).on('click', '#commonly-gallery-content .am-pagination a', function(){
            var url = $(this).attr('href');
            if(!url || url == 'javascript:;'){
                return false;
            }
            $.get(url, function (data) {
                gallery_dialog.content('<div id="commonly-gallery-content">' + data + '</div>');
            });
            return false;
        });

        $(document).on('click', '#commonly-gallery-content .search', function(){
            var url = $(this).parents('form').attr('action');
            var keyword = $(this).parents('form').find('input[name=keyword]').val();
            $.get(url+keyword, function (data) {
                gallery_dialog.content('<div id="commonly-gallery-content">' + data + '</div>');
            });
            return false;
        });

        /**
         * 选择图片
         */
        $(document).on('click', '#commonly-gallery-content .am-gallery a', function(){
            if (gallery_option.multiple == true) {
                var name = gallery_option.name + '[]';
            } else {
                var name = gallery_option.name;
                $("#before" + gallery_option.id).prevAll().remove();
            }

            AMUIwebuploader.append({
                id: gallery_option.id,
                src: $(this).find('img').attr('src'),
                name: name
            });
            gallery_dialog.close();
        });

    };


});
/**
 * 用JS调用的方法
 * @type {{
 * template: AMUIwebuploader.template, 上传按钮的模板
 * init: AMUIwebuploader.init 初始化上传按钮
 * }}
 */
var AMUIwebuploader = {
    /**
     * 上传按钮的模板
     * @param id 上传按钮绑定的ID名称
     * @returns {string} 返回模板
     */
    template: function (id, type, multiple, gallery) {
        var str = '';
        if (type != 'file' && gallery == true) {
            str = '<li class="am-margin-top" id="commonly' + id + '">' +
                '<a href="javascript:;" class="am-padding-top-lg commonly" data="' + id + '" data-multiple="'+multiple+'">' +
                '<i class=" am-danger am-icon-hand-o-right am-margin-top-lg am-icon-lg"></i> 打开图库' +
                '</a>' +
                '</li>';
        }

        return (
        '<ul class="am-gallery am-avg-lg-10 am-gallery-overlay am-webuploader-ul" >' +
        '<li id="before' + id + '">' +
        '<div class="am-gallery-item webuploader-item am-img-thumbnail webuploader-background-img">' +
        '<a href="javascript:;" id="' + id + '">' +
        '</a>' +
        '</div>' +
        '</li>' +
        str +
        '</ul>');
    },

    /**
     * 追加内容
     * @param 必要的参数 param:{id:'', src:'', name:''}
     */
    append:function(param){
        $li = '<div class="am-gallery-item webuploader-item am-img-thumbnail">' +
            '<a href="javascript:;" >' +
            '<img src="' + param.src + '"  alt="点击上传图片"/>' +
            '<h3 class="am-gallery-title am-text-center am-hide"></h3>' +
            '</a>' +
            '</div>' +
            '<input type="hidden" name="' + param.name + '" value="' + param.src + '">';
        $("#before" + param.id).before('<li id="' + Math.random() + '">' + $li + '</li>');
    },
    /**
     * 初始化上传按钮
     * @param dom 手动追加上传按钮放置的位置。DOM为该标签的ID名称。
     * @param obj 上传组件的对象。最少填入对象内容为：{id:'按钮的ID名称', name:'上传成功返回的隐藏域名称', pick:{id:'#按钮的ID名称 '}}
     */
    init: function (dom, obj) {
        $('#' + dom).html(this.template(obj.id, obj.type, obj.pick.multiple, obj.gallery));
        $.webuploader_for_amazeui(obj);
    },

    options : function(string) {
        if ($.isPlainObject(string)) {
            return string;
        }
        var start = (string ? string.indexOf('{') : -1);
        var options = {};

        if (start != -1) {
            try {
                options = (new Function('',
                    'var json = ' + string.substr(start) +
                    '; return JSON.parse(JSON.stringify(json));'))();
            } catch (e) {
            }
        }

        return options;
    }
}