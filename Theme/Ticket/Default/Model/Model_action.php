<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
    <script>
        $(function () {

            var method = $("input[name=method]").val();
            if (method == 'PUT') {
                $("input[name=name]").attr("readonly", "readonly");

            }
        })
    </script>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>