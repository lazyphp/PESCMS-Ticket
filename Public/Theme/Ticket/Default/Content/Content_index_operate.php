<?php
/**
 * 本模板为通用编辑按钮，若没有特殊需求，请加载本模板
 */
$echoEditUrl = empty($editUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('id' => $label->xss($value["{$fieldPrefix}id"]), 'back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $editUrl;
$echoDeleteUrl = empty($deleteUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('id' => $label->xss($value["{$fieldPrefix}id"]), 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $deleteUrl;

?>
<?php if($label->checkAuth(GROUP.'GET'.MODULE.'action') === true): ?>
<a class="am-text-secondary" href="<?= $echoEditUrl ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
<?php endif; ?>

<?php if($label->checkAuth(GROUP.'DELETE'.MODULE.'action') === true): ?>
<i class="am-margin-left-xs am-margin-right-xs">|</i>
<a class="am-text-danger ajax-click ajax-dialog"  msg="确定删除吗？将无法恢复的！" href="<?= $echoDeleteUrl; ?>"><span class="am-icon-trash-o"></span> 删除</a>
<?php endif; ?>

<?php $label->opEvent(['id' => $value["{$fieldPrefix}id"]]) ?>
