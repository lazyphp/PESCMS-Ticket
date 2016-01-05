<div id="uploader">
    <?php if (!empty($field['value'])): ?>
        <?php foreach (explode(',', $field['value']) as $key => $value) : ?>
            <div class="form-text" id="<?= $key . $field['field_name'] ?>">
                <input type="text" class="form-text-input input-leng3" name="<?= $field['field_name'] ?>[]" value="<?= $value ?>" />
                <a href="javascript:;" onclick="removeUploadFile('<?= $key . $field['field_name'] ?>')" class="blue-button" style="margin-left:5px;">删除</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <div id="<?= $field['field_name'] ?>List" class="uploader-list"></div>

    <div id="<?= $field['field_name'] ?>" style="margin-top: 10px;">请选择上传文件</div>
</div>
<script>
    jQuery(function () {

        var $ = jQuery,
                $list = $('#<?= $field['field_name'] ?>List'),
                // Web Uploader实例
                uploader;

        // 初始化Web Uploader
        uploader = WebUploader.create({
            // 自动上传。
            auto: true,
            // swf文件路径
            swf: '../../dist/Uploader.swf',
            // 文件接收服务端。
            server: '/index.php?g=<?=GROUP?>&m=Upload&a=file',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                id: '#<?= $field['field_name'] ?>',
                multiple: false
            },
            duplicate: true
        });

        // 当有文件添加进来的时候
        uploader.on('fileQueued', function (file) {
            var $li = $(
                    '<div id="' + file.id + '" class="file-item">' +
                    '<div class="info">' + file.name + '</div>' +
                    '</div>'
                    )
            $list.html($li).fadeOut(3000);
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
                var rand = Math.round(Math.random() * 10000 * Math.random());
                $("#<?= $field['field_name'] ?>List").before('<dt class="form-text" id="' + rand + '<?= $field['field_name'] ?>">Upload File \'' + file.name + '\' : <input type="text" class="form-text-input input-leng3" name="<?= $field['field_name'] ?>[]" value="' + response.info + '" /><a href="javascript:;" onclick="removeUploadFile(\'' + rand + '<?= $field['field_name'] ?>\')" class="blue-button" style="margin-left:5px;" >删除</a></dt>')

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