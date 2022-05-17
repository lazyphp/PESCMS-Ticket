<?php
/**
 * 本模板为智能表单添加/编辑模式下的隐藏表单模板
 * 定制开发中，若没有特殊的需求，请加载本模板。
 */
?>
<input type="hidden" name="method" value="<?= $method ?? null ?>"/>
<input type="hidden" name="id" value="<?= $id ?? null ?>"/>
<input type="hidden" name="back_url" value="<?= $_GET['back_url'] ?? null ?>"/>
<?= $label->token() ?>