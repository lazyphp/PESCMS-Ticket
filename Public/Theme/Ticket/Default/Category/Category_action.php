<?php include THEME_PATH . '/Content/Content_action_header.php' ?>
<?php include THEME_PATH . '/Content/Content_action_hidden.php' ?>
<?php include THEME_PATH . '/Content/Content_action_form.php' ?>
<?php include THEME_PATH . '/Content/Content_action_footer.php' ?>
<div class="am-hide">
    <select>
        <option value="0">顶层分类</option>
        <?php foreach($select as $key => $value): ?>
            <option value="<?= $value['category_id'] ?>" <?= $_GET['id'] == $value['category_id'] ? 'disabled="disabled"' : '' ?> <?= $category_parent == $value['category_id'] ? 'selected="selected"' :'' ?> ><?= $value['space'].$value['guide'].$value['category_name'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
<script>
    $(function(){
        $('select[name=parent]').html($('.am-hide select').html())
    })
</script>
