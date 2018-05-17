<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>
<script>
    $(function(){
        var str = '<option value="0">顶层分类</option><?= $select ?>';
        $('select[name=parent]').html(str)
    })
</script>
