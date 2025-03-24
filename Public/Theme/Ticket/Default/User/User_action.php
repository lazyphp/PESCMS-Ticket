<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
    <script>
        $(function () {
            $("input[name=password]").val('');

            <?php if(empty($_GET['id'])): ?>
            $('input[name="job_number"]').val('<?= $job_number ?>');
            <?php endif; ?>

        })
    </script>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>