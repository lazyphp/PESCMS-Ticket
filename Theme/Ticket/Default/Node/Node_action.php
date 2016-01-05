<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
    <script>
        $(function() {
            var dom = $("select[name=method_type], input[name=verify], input[name=msg]").closest('li');
            console.dir(dom)
            if ($("select[name=controller] option:selected").val() > '0') {
                dom.removeClass("am-hide");
            } else {
                dom.addClass("am-hide");
            }
            $("select[name=controller]").on("change", function() {
                if ($(this).val() > '0') {
                    dom.removeClass("am-hide");
                } else {
                    dom.addClass("am-hide");
                }
            })
        })
    </script>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>