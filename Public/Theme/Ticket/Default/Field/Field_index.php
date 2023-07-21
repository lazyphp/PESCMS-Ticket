<?php include THEME_PATH . "/Content/Content_index_header.php"; ?>

<?php include THEME_PATH . "/Content/Content_index_tool.php"; ?>
<script>
    $(function(){
        $("input[name=keyword]").after('<input type="hidden" name="model_id" value="<?= (int)$_GET['model_id']?>"/><input type="hidden" name="back_url" value="<?=!empty($_GET['back_url']) ? $label->xss($_GET['back_url']) : null?>"/>')
    })
</script>

<?php include THEME_PATH . "/Content/Content_index_list.php"; ?>

<?php include THEME_PATH . "/Content/Content_index_footer.php"; ?>
