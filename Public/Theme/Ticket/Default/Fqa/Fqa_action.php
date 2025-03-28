<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>
<script>
    $(function () {
        // 初始化时检查单选框的值
        function toggleFields() {
            var type = $('input[name="type"]:checked').val();
            
            if (type === '0') {
                // 当type为0时
                $('[name="title"]').closest('.am-g.am-g-collapse').show();
                $('#content').closest('.am-g.am-g-collapse').show();
                $('[name="link"]').closest('.am-g.am-g-collapse').hide();
                // 移除link的必填属性
                $('[name="link"]').removeAttr('required');
            } else if (type === '1') {
                // 当type为1时
                $('[name="title"]').closest('.am-g.am-g-collapse').hide();
                $('#content').closest('.am-g.am-g-collapse').hide();
                $('[name="link"]').closest('.am-g.am-g-collapse').show();
                // 添加link的必填属性
                $('[name="link"]').attr('required', 'required');
            }
        }

        // 页面加载完成后执行一次
        toggleFields();

        // 监听单选框的变化
        $('input[name="type"]').on('change', function() {
            toggleFields();
        });

        // 表单提交验证
        $('form').on('submit', function(e) {
            var type = $('input[name="type"]:checked').val();
            
            if (type === '0') {
                // 检查百度编辑器内容
                var content = UE.getEditor('content').getContent();
                var $formGroup = $('#content').closest('.am-form-group');
                var $editor = $('.edui-editor');
                
                if (!content) {
                    e.preventDefault();
                    // 添加错误样式
                    $formGroup.removeClass('am-form-success').addClass('am-form-error');
                    $editor.removeClass('am-field-valid').addClass('am-field-error');
                    return false;
                } else {
                    // 添加成功样式
                    $formGroup.removeClass('am-form-error').addClass('am-form-success');
                    $editor.removeClass('am-field-error').addClass('am-field-valid');
                }
            }
        });
    });
</script>
