<div id="uploader">
    <input type="hidden" name="<?= $field['field_name'] ?>" value="<?= $field['value'] ?>" />
    <div id="<?= $field['field_name'] ?>List" class="uploader-list">
        <?php if ($field['value']): ?>
            <div class="file-item thumbnail">
                <img src="<?= $field['value'] ?>" width="200" height="200" />
            </div>
        <?php endif; ?>
    </div>
    <div id="<?= $field['field_name'] ?>" size="<?= implode('-', json_decode($field['field_option'], true)); ?>">选择图片</div>
</div>
<script>
    jQuery(function () {

        /**
         * 上传图片的大小
         * 调用中必须声明上传图片的尺寸
         * 参数为:宽-高
         */
        if (jQuery("#<?= $field['field_name'] ?>").attr("size") != '' && jQuery("#<?= $field['field_name'] ?>").attr("size") != undefined) {
            var imgSize = jQuery("#<?= $field['field_name'] ?>").attr("size").split("-");
        }

        var $ = jQuery,
                $list = $('#<?= $field['field_name'] ?>List'),
                // 优化retina, 在retina下这个值是2
                ratio = window.devicePixelRatio || 1,
                // 缩略图大小
                thumbnailWidth = 100 * ratio,
                thumbnailHeight = 100 * ratio,
                // Web Uploader实例
                uploader;

        // 初始化Web Uploader
        uploader = WebUploader.create({
            // 自动上传。
            auto: true,
            // swf文件路径
            swf: '../../dist/Uploader.swf',
            // 文件接收服务端。
            server: '/index.php?g=<?=GROUP?>&m=Upload&a=img',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                id: '#<?= $field['field_name'] ?>',
                multiple: false
            },
            // 只允许选择文件，可选。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            formData: {
                imgSize: imgSize
            }
        });

        // 当有文件添加进来的时候
        uploader.on('fileQueued', function (file) {
            var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '<div class="info">' + file.name + '</div>' +
                    '</div>'
                    ),
                    $img = $li.find('img');
            $list.html($li);

            // 创建缩略图
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $img.replaceWith('<span>无法预览</span>');
                    return;
                }

                $img.attr('src', src);
            }, thumbnailWidth, thumbnailHeight);
        });

        // 文件上传过程中创建进度条实时显示。
        uploader.on('uploadProgress', function (file, percentage) {
            var $li = $('#' + file.id),
                    $percent = $li.find('.progress span');

            // 避免重复创建
            if (!$percent.length) {
                $percent = $('<p class="progress"><span></span></p>')
                        .appendTo($li)
                        .find('span');
            }

            $percent.css('width', percentage * 100 + '%');
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function (file, response) {
            if (response.status == '200') {

                $("input[name=<?= $field['field_name'] ?>]").val(response.info);

                var $li = $('#' + file.id),
                        $success = $li.find('div.success');

                // 避免重复创建
                if (!$success.length) {
                    $success = $('<div class="success"></div>').appendTo($li);
                }

                $success.text('上传成功');

            } else {
                var $li = $('#' + file.id),
                        $error = $li.find('div.error');

                // 避免重复创建
                if (!$error.length) {
                    $error = $('<div class="error"></div>').appendTo($li);
                }
                $list.html($error.text(response.info));
            }
        });

        // 文件上传失败，现实上传出错。
        uploader.on('uploadError', function (file) {
            var $li = $('#' + file.id),
                    $error = $li.find('div.error');

            // 避免重复创建
            if (!$error.length) {
                $error = $('<div class="error"></div>').appendTo($li);
            }
            $list.html($error.text('上传失败'));
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete', function (file) {
            $('#' + file.id).find('.progress').remove();
        });
    });
</script>