<?php

$editUrl = $label->url(GROUP . '-' . MODULE . '-action', array('id' => $value["{$fieldPrefix}id"], 'model_id' => $_GET['model_id'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])));

$deleteUrl = $label->url(GROUP . '-' . MODULE . '-action', array('id' => $value["{$fieldPrefix}id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])));

?>
<div class="am-btn-toolbar">
    <div class="am-btn-group am-btn-group-xs">
        <a class="am-text-secondary" href="<?= $editUrl ?>"><span class="am-icon-pencil-square-o"></span> 编辑</a>
        <i class="am-margin-left-xs am-margin-right-xs">|</i>
        <a class="am-text-danger ajax-click ajax-dialog"  msg="确定删除吗？将无法恢复的！"
           href="<?= $deleteUrl; ?>" ><span class="am-icon-trash-o"></span> 删除</a>
    </div>
</div>