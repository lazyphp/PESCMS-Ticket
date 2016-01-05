<div id="container">
    <div id="uploader">
        <div class="queueList">

            <ul class="filelist" id="<?= $field['field_name'] ?>List">
                <?php if (!empty($field['value'])): ?>
                    <?php foreach (explode(',', $field['value']) as $key => $value) : ?>
                        <li id="<?= $key ?>pics">
                            <p><img src="<?= $value ?>"></p>
                            <div class="file-panel" style="height: 0px;"><span class="cancel" data="<?= $key ?>">删除</span></div>
                        </li>
                        <input type="hidden" id="<?= $key ?>input" name="<?= $field['field_name'] ?>[]" value="<?= $value ?>" />

                    <?php endforeach; ?>
                <?php else: ?>
                    <li id="example-pics">
                        <p><img src="/Theme/assets/i/image.png"></p>
                    </li>
                <?php endif; ?>
            </ul>
            <p id="info"><?= empty($field['value']) ? '选择您要上传的图片' : ''; ?></p>
        </div>
        <div class="statusBar">
            <div class="progress" style="display: none;">
                <span class="text">0%</span>
                <span class="percentage" style="width: 0%;"></span>
            </div>
            <div class="btns">
                <div id="<?= $field['field_name'] ?>" size="400-400">选择图片</div>
            </div>
        </div>
    </div>
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
        var guid;

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
                id: '#<?= $field['field_name'] ?>'
            },
            // 只允许选择文件，可选。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            formData: {
                imgSize: imgSize
            },
        });


        // 当有文件添加进来的时候
        uploader.on('fileQueued', function (file) {
            $("#example-pics").remove();
            guid = Math.round(Math.random() * 10000 * (Math.random() * 100));
            var $li = $(
                    '<li id="' + guid + 'pics">' +
                    '<p><img></p>' +
                    '<div class="file-panel" style="height: 0px;"><span class="cancel" data="' + guid + '">删除</span></div>' +
                    '</li>'
                    ),
                    $img = $li.find('img');
            $list.append($li);

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
                $('#info').html(file.name + '上传成功');
                $("#info").after('<input type="hidden" id="' + guid + 'input" name="<?= $field['field_name'] ?>[]" value="' + response.info + '" />');

            } else {
                $("#" + guid).remove();
                $('#info').html(response.info);
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

        jQuery("#<?= $field['field_name'] ?>List").on('mouseenter', 'li', function () {
            jQuery(this).find(".file-panel").stop().animate({height: 30});
        });


        jQuery("#<?= $field['field_name'] ?>List").on('mouseleave', 'li', function () {
            jQuery(this).find(".file-panel").stop().animate({height: 0});
        });

        //执行删除动作
        jQuery("#<?= $field['field_name'] ?>List").on("click", '.cancel', function () {
            var data = jQuery(this).attr("data");
            jQuery("#" + data + 'pics').remove();
            jQuery("#" + data + 'input').remove();
            if (!jQuery("#<?= $field['field_name'] ?>List").find("li").length) {
                var $li = $(
                        '<li id="example-pics" style="background: none">' +
                        '<p><img src="/Theme/assets/i/image.png"></p>' +
                        '</li>'
                        )
                jQuery("#<?= $field['field_name'] ?>List").append($li);
                jQuery("#info").html('选择您要上传的图片');

            }

        })
    });
</script>
