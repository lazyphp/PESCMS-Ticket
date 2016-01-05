<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
    <input type="hidden" name="method" value="<?= $method ?>"/>
    <input type="hidden" name="id" value="<?= $ticket_model_number ?>"/>
    <input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?>"/>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>