<?php
/**
 * 本模板为通用编辑按钮，若没有特殊需求，请加载本模板
 */
$echoEditUrl = empty($editUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('id' => $value["{$fieldPrefix}id"], 'back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $editUrl;
$echoDeleteUrl = empty($deleteUrl) ? $label->url(GROUP . '-' . MODULE . '-action', array('id' => $value["{$fieldPrefix}id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))) : $deleteUrl;

?>
<div class="am-btn-toolbar">
    <div class="am-btn-group am-btn-group-xs">
        <a class="am-btn am-btn-secondary" href="<?= $echoEditUrl ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
        <a class="am-btn am-btn-danger"
           href="<?= $echoDeleteUrl; ?>"
           onclick="return confirm('确定删除吗?')"><span class="am-icon-trash-o"></span> 删除</a>
    </div>
</div>