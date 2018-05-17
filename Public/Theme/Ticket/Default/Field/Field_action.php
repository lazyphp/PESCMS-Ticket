<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
    <input type="hidden" name="model_id" value="<?= $_GET['model_id'] ?>"/>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
    <script>
        $(function () {
            /**
             * 动态解析选项值
             */
            var option = $("textarea[name=option]").val();
            if (option != '' && option != undefined) {
                var objOption = eval('(' + option + ')');
                var str = '';
                for (var key in objOption) {
                    str += key + '|' + objOption[key] + "\n";
                }
                $("textarea[name=option]").val(str.trim());
            }

            /**
             * 要切换表单的类型，只能删除再重建
             */
            var method = $("input[name=method]").val();
            var typeValue = $("select[name=type]").val();
            if (method == 'PUT') {
                $("select[name=type]").attr("readonly", "readonly");
            }

            $("select[name=type]").change(function () {
                if (method == 'PUT') {
                    $(this).val(typeValue);
                }
            })
        })
    </script>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>